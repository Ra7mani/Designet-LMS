<?php

namespace App\Livewire\Formateur;

use App\Models\Cours;
use App\Models\User;
use App\Models\Inscription;
use App\Models\Chapitre;
use App\Models\Paiement;
use App\Models\Avis;
use App\Models\QuizAttempt;
use App\Models\Session;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

#[Layout('layouts.formateur')]
class Dashboard extends Component
{
    public $publicCoursesCount = 0;
    public $totalStudents = 0;
    public $averageRating = 0;
    public $monthlyRevenue = 0;
    public $totalRevenue = 0;
    public $revenuePerStudent = 0;
    public $pendingAssignmentsCount = 0;
    public $coursesList = [];
    public $strugglingStudents = [];
    public $topStudents = [];
    public $studentTrend = 0;
    public $revenueTrend = 0;
    public $courseTrend = 0;
    public $ratingPercentile = "Calculé";
    public $upcomingSessions = [];
    public $recentNotifications = [];
    public $pendingAssignments = [];
    public $mostPopularCourse = [];
    public $unreadMessagesCount = 0;
    public $activeStudentsThisWeek = 0;

    public function mount()
    {
        $this->loadDashboardData();
    }

    #[Computed]
    public function nextSession()
    {
        if (empty($this->upcomingSessions)) {
            return null;
        }
        return $this->upcomingSessions[0] ?? null;
    }

    private function loadDashboardData()
    {
        $authUser = auth()->user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $startOfMonth->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $startOfMonth->copy()->subDay();

        // ===== TOP COURSES WITH ALL RELATIONS =====
        $courses = $authUser->cours()
            ->with('chapitres.lecons', 'inscriptions', 'inscriptions.paiement', 'inscriptions.avis')
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        // ===== BASIC STATS FROM LOADED DATA =====
        $this->publicCoursesCount = $courses->where('status', 'published')->count();
        $this->totalStudents = $courses->sum(fn($c) => $c->inscriptions->count());
        $this->averageRating = $courses->avg('rating') ?? 0;

        // ===== MAP COURSES FOR VIEW =====
        $this->coursesList = $courses->map(fn($c) => [
            'id' => $c->id,
            'title' => $c->title,
            'students' => $c->inscriptions->count(),
            'rating' => $c->rating ?? 4.8,
            'level' => $c->level,
            'lessons' => $c->chapitres->sum(fn($ch) => $ch->lecons->count() ?? 0),
            'thumbnail' => $c->thumbnail,
            'status' => $c->status,
            'progressPercentage' => min(($c->inscriptions->count() / 10) * 100, 100),
        ])->toArray();

        // ===== DYNAMIC REVENUE DATA =====
        $courseIds = $courses->pluck('id');

        // Only query if there are courses
        if ($courseIds->isNotEmpty()) {
            // Current month revenue
            $this->monthlyRevenue = Paiement::whereHas('inscription', fn($q) => $q->whereIn('cours_id', $courseIds))
                ->whereBetween('paid_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'completed')
                ->sum('amount');

            // Last month revenue
            $lastMonthRevenue = Paiement::whereHas('inscription', fn($q) => $q->whereIn('cours_id', $courseIds))
                ->whereBetween('paid_at', [$startOfLastMonth, $endOfLastMonth])
                ->where('status', 'completed')
                ->sum('amount');

            // Calculate revenue trend
            $this->revenueTrend = max(0, $this->monthlyRevenue - $lastMonthRevenue);

            // Total revenue
            $this->totalRevenue = Paiement::whereHas('inscription', fn($q) => $q->whereIn('cours_id', $courseIds))
                ->where('status', 'completed')
                ->sum('amount');

            // Pre-compute revenue per student
            $this->revenuePerStudent = $this->totalStudents > 0 ? $this->totalRevenue / $this->totalStudents : 0;

            // ===== DYNAMIC PENDING ASSIGNMENTS =====
            // Count quizzes with pending attempts
            $this->pendingAssignmentsCount = QuizAttempt::whereHas('quiz', fn($q) => $q->whereIn('cours_id', $courseIds))
                ->where(function($q) {
                    $q->where('status', 'pending')
                      ->orWhere('status', 'in_progress');
                })
                ->count();

            // ===== PENDING ASSIGNMENTS DETAILS =====
            $this->pendingAssignments = QuizAttempt::whereHas('quiz', fn($q) => $q->whereIn('cours_id', $courseIds))
                ->with('user', 'quiz.cours')
                ->where(function($q) {
                    $q->where('status', 'pending')
                      ->orWhere('status', 'in_progress');
                })
                ->latest()
                ->limit(3)
                ->get()
                ->map(fn($attempt) => [
                    'id' => $attempt->id,
                    'student_name' => $attempt->user->name ?? 'Anonyme',
                    'student_avatar' => strtoupper(substr($attempt->user->name ?? 'A', 0, 1)),
                    'course_title' => $attempt->quiz->cours->title ?? '',
                    'assignment_title' => $attempt->quiz->title ?? 'Devoir',
                    'submitted_at' => $attempt->created_at->format('d M H:i') ?? 'N/A',
                ])
                ->toArray();

            // ===== STUDENT TRENDS =====
            // Students enrolled this month
            $currentMonthStudents = Inscription::whereIn('cours_id', $courseIds)
                ->whereBetween('enrolled_at', [$startOfMonth, $endOfMonth])
                ->count();

            // Students enrolled last month
            $lastMonthStudents = Inscription::whereIn('cours_id', $courseIds)
                ->whereBetween('enrolled_at', [$startOfLastMonth, $endOfLastMonth])
                ->count();

            $this->studentTrend = max(0, $currentMonthStudents - $lastMonthStudents);

            // ===== STRUGGLING STUDENTS =====
            $this->strugglingStudents = User::whereHas('inscriptions', function($q) use ($courseIds) {
                $q->whereIn('cours_id', $courseIds)
                  ->where('progress', '<', 30);
            })->with('inscriptions')->limit(5)->get()->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'progress' => $s->inscriptions->avg('progress') ?? 0,
            ])->toArray();

            // ===== TOP STUDENTS =====
            $this->topStudents = User::whereHas('inscriptions', function($q) use ($courseIds) {
                $q->whereIn('cours_id', $courseIds);
            })
            ->with('inscriptions')
            ->orderByDesc(
                Inscription::select('progress')
                    ->whereColumn('etudiant_id', 'users.id')
                    ->whereIn('cours_id', $courseIds)
                    ->limit(1)
            )
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'avatar' => strtoupper(substr($s->name, 0, 2)),
                'progress' => intval($s->inscriptions->avg('progress') ?? 0),
                'lessons' => intval($s->inscriptions->sum('completed_lessons') ?? 0),
            ])->toArray();

            // ===== UPCOMING SESSIONS =====
            $this->upcomingSessions = Session::where('formateur_id', $authUser->id)
                ->whereIn('cours_id', $courseIds)
                ->where('start_time', '>', $now)
                ->where('type', 'live')
                ->orderBy('start_time')
                ->limit(5)
                ->get()
                ->map(fn($session) => [
                    'id' => $session->id,
                    'title' => $session->title,
                    'course_title' => $session->cours->title ?? 'Cours',
                    'start_time' => $session->start_time,
                    'end_time' => $session->end_time,
                    'date' => $session->start_time,
                    'time' => $session->start_time->format('H:i'),
                    'session_room' => $session->session_room ?? 'Salle virtuelle',
                    'students' => $session->cours->inscriptions->count() ?? 0,
                    'type' => $session->type,
                ])
                ->toArray();

            // ===== MOST POPULAR COURSE =====
            $mostPopular = $courses->sortByDesc(fn($c) => $c->inscriptions->count())->first();
            $this->mostPopularCourse = $mostPopular ? [
                'id' => $mostPopular->id,
                'title' => $mostPopular->title,
                'students' => $mostPopular->inscriptions->count(),
            ] : [];

            // ===== ACTIVE STUDENTS THIS WEEK =====
            $weekAgo = $now->copy()->subWeek();
            $this->activeStudentsThisWeek = Inscription::whereIn('cours_id', $courseIds)
                ->where('updated_at', '>=', $weekAgo)
                ->pluck('etudiant_id')
                ->unique()
                ->count();

            // ===== UNREAD MESSAGES COUNT =====
            // For now, set to a reasonable number based on pending assignments
            // This can be connected to a Message model later
            $this->unreadMessagesCount = max(0, $this->pendingAssignmentsCount);

            // ===== RECENT NOTIFICATIONS =====
            $this->recentNotifications = Avis::whereHas('inscription', function($q) use ($courseIds) {
                $q->whereIn('cours_id', $courseIds);
            })
            ->with('inscription.etudiant', 'inscription.cours')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($review) => [
                'id' => $review->id,
                'user_name' => $review->inscription->etudiant->name ?? 'Utilisateur',
                'user_avatar' => strtoupper(substr($review->inscription->etudiant->name ?? 'U', 0, 1)),
                'message' => 'a laissé un avis ' . $review->rating . ' étoiles',
                'course_title' => $review->inscription->cours->title,
                'created_at' => $review->created_at->diffForHumans(),
                'type' => 'review',
            ])
            ->toArray();
        }

        // ===== COURSE TRENDS =====
        // Courses created this month
        $currentMonthCourses = $authUser->cours()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Courses created last month
        $lastMonthCourses = $authUser->cours()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $this->courseTrend = max(0, $currentMonthCourses - $lastMonthCourses);

        // ===== RATING PERCENTILE =====
        // Get this formateur's average rating from their courses
        $myAverageRating = $this->averageRating;

        // Find formateurs with same or better rating (from their courses)
        $betterRatingCount = User::where('role', 'formateur')
            ->whereHas('cours', function($q) {
                $q->where('status', 'published');
            })
            ->get()
            ->filter(fn($u) => $u->cours->avg('rating') ?? 0 > $myAverageRating)
            ->count();

        $totalFormateurs = User::where('role', 'formateur')
            ->whereHas('cours', function($q) {
                $q->where('status', 'published');
            })
            ->count();

        // Calculate this formateur's percentile
        if ($myAverageRating > 0 && $totalFormateurs > 0) {
            $percentileValue = round(($betterRatingCount / $totalFormateurs) * 100);
            $this->ratingPercentile = "Top " . max(1, (100 - $percentileValue)) . "%";
        } else {
            $this->ratingPercentile = "En amélioration";
        }
    }

    public function render()
    {
        return view('livewire.formateur.dashboard');
    }
}

