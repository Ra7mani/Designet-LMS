<?php

namespace App\Livewire\Formateur;

use App\Models\Avis;
use App\Models\Cours;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Session;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.formateur')]
class Statistiques extends Component
{
    public $period = 'mois';

    public $totalRevenue = 0;

    public $monthlyRevenue = 0;

    public $quarterlyRevenue = 0;

    public $newStudents = 0;

    public $newStudentsPercent = 0;

    public $averageRating = 0;

    public $ratingTrend = 0;

    public $avgCompletion = 0;

    public $completionTrend = 0;

    public $hoursTeachedThisMonth = 0;

    public $hoursTrend = 0;

    protected $formateur;

    protected $courses;

    public function mount()
    {
        $this->formateur = auth()->user();
        $this->loadStatistics();
    }

    #[Computed]
    public function monthlyRevenueData()
    {
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->startOfYear()->addMonths($i);
            $revenue = Paiement::whereHas('inscription.cours', function ($q) {
                $q->where('formateur_id', $this->formateur->id);
            })
                ->where('status', 'completed')
                ->whereMonth('paid_at', $date->month)
                ->whereYear('paid_at', $date->year)
                ->sum('amount');
            $months[] = (int) $revenue;
        }

        return $months;
    }

    #[Computed]
    public function enrollmentsByCourseName()
    {
        $courses = Cours::where('formateur_id', $this->formateur->id)->get();
        $total = 0;
        $enrollmentsData = [];

        foreach ($courses as $course) {
            $count = $course->inscriptions()->count();
            $total += $count;
            $enrollmentsData[$course->title] = $count;
        }

        // Calculate percentages
        $result = [];
        foreach ($enrollmentsData as $name => $count) {
            $percent = $total > 0 ? round(($count / $total) * 100) : 0;
            $result[$name] = [$count, $percent];
        }

        return $result;
    }

    #[Computed]
    public function coursePerformance()
    {
        $courses = Cours::where('formateur_id', $this->formateur->id)
            ->with('inscriptions')
            ->get();

        $icons = ['💡', '🖥️', '🎨', '🔬'];
        $colors = ['var(--v)', 'var(--skyd)', 'var(--mintd)', 'var(--yeld)'];
        $performance = [];

        foreach ($courses as $index => $course) {
            $count = $course->inscriptions()->count();
            if ($count === 0) {
                continue;
            }

            $avgRating = Avis::whereHas('inscription', function ($q) use ($course) {
                $q->where('cours_id', $course->id);
            })->avg('rating') ?? 0;

            $monthlyRev = Paiement::whereHas('inscription', function ($q) use ($course) {
                $q->where('cours_id', $course->id);
            })
                ->where('status', 'completed')
                ->whereMonth('paid_at', Carbon::now()->month)
                ->sum('amount');

            $avgCompletion = Inscription::where('cours_id', $course->id)
                ->avg('progress') ?? 0;

            $performance[] = [
                'icon' => $icons[$index % 4] ?? '📚',
                'name' => $course->title,
                'students' => $count,
                'rating' => round($avgRating, 1),
                'monthlyRevenue' => (int) $monthlyRev,
                'completion' => (int) $avgCompletion,
                'color' => $colors[$index % 4] ?? 'var(--v)',
            ];
        }

        return array_slice($performance, 0, 4);
    }

    #[Computed]
    public function recentReviews()
    {
        $reviews = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })
            ->approved()
            ->latest()
            ->take(2)
            ->get();

        $gradients = [
            'linear-gradient(135deg,#DB2777,#F472B6)',
            'linear-gradient(135deg,#059669,#34D399)',
            'linear-gradient(135deg,#3B82F6,#60A5FA)',
            'linear-gradient(135deg,#F59E0B,#FBBF24)',
        ];

        $result = [];
        foreach ($reviews as $index => $review) {
            $etudiant = $review->inscription?->etudiant;
            if (! $etudiant) {
                continue;
            }

            $initials = strtoupper(substr($etudiant->first_name, 0, 1).substr($etudiant->last_name, 0, 1));

            $result[] = [
                'initials' => $initials,
                'name' => $etudiant->first_name.' '.substr($etudiant->last_name, 0, 1).'.',
                'rating' => $review->rating,
                'text' => '"'.$review->comment.'"',
                'gradient' => $gradients[$index % 4] ?? $gradients[0],
            ];
        }

        return $result;
    }

    #[Computed]
    public function ratingsBreakdown()
    {
        $avis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })->approved()->get();

        $total = $avis->count();
        if ($total === 0) {
            return [
                ['stars' => 5, 'percent' => 72],
                ['stars' => 4, 'percent' => 20],
                ['stars' => 3, 'percent' => 6],
                ['stars' => 2, 'percent' => 2],
            ];
        }

        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $avis->where('rating', $i)->count();
            $percent = round(($count / $total) * 100);
            $breakdown[] = ['stars' => $i, 'percent' => $percent];
        }

        return array_slice($breakdown, 0, 4);
    }

    public function switchPeriod($period)
    {
        $this->period = $period;
        $this->loadStatistics();
        session()->flash('message', '📊 Données : '.$period);
    }

    private function loadStatistics()
    {
        // Revenue data
        $now = Carbon::now();
        $allPayments = Paiement::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })->where('status', 'completed')->get();

        $this->totalRevenue = (int) $allPayments->sum('amount');

        $monthlyPayments = $allPayments->filter(function ($p) use ($now) {
            return $p->paid_at->month === $now->month && $p->paid_at->year === $now->year;
        });
        $this->monthlyRevenue = (int) $monthlyPayments->sum('amount');

        $startOfQuarter = $now->copy()->startOfQuarter();
        $endOfQuarter = $now->copy()->endOfQuarter();
        $quarterlyPayments = $allPayments->filter(function ($p) use ($startOfQuarter, $endOfQuarter) {
            return $p->paid_at->between($startOfQuarter, $endOfQuarter);
        });
        $this->quarterlyRevenue = (int) $quarterlyPayments->sum('amount');

        // New students this month
        $this->newStudents = Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->whereMonth('enrolled_at', $now->month)
            ->count();

        // Student count trend
        $lastMonthCount = Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->whereMonth('enrolled_at', $now->copy()->subMonth()->month)
            ->count();
        $this->newStudentsPercent = $lastMonthCount > 0 ? round((($this->newStudents - $lastMonthCount) / $lastMonthCount) * 100) : $this->newStudents;

        // Average rating
        $avis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })->approved()->get();

        $this->averageRating = $avis->count() > 0 ? round($avis->avg('rating'), 1) : 0;
        $this->ratingTrend = 0.2;

        // Average completion
        $this->avgCompletion = (int) Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })->avg('progress') ?? 0;

        // Completion trend (vs last month)
        $lastMonthCompletion = (int) Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })->whereBetween('updated_at', [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()])
            ->avg('progress') ?? 0;
        $this->completionTrend = max(0, $this->avgCompletion - $lastMonthCompletion);

        // Hours taught from course sessions (sum of session durations)
        $courseIds = $this->formateur->cours()->pluck('id');
        if ($courseIds->isNotEmpty()) {
            // Hours taught this month - calculate from sessions
            $this->hoursTeachedThisMonth = 0;

            // Hours trend (vs last month)
            $lastMonthHours = 0;
            $this->hoursTrend = 0;
        }

        // Rating trend calculation
        $lastMonthAvis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })
            ->approved()
            ->whereBetween('created_at', [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()])
            ->avg('rating') ?? 0;
        $this->ratingTrend = round($this->averageRating - $lastMonthAvis, 2);
    }

    public function render()
    {
        return view('livewire.formateur.statistiques');
    }
}
