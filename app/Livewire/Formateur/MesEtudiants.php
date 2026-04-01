<?php

namespace App\Livewire\Formateur;

use App\Models\DirectMessage;
use App\Models\Inscription;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class MesEtudiants extends Component
{
    use WithPagination;

    public $filter = 'tous';

    public $courseFilter = null;

    public $sortBy = 'recent';

    public $searchQuery = '';

    public $selectedStudentId = null;

    public $inactiveDaysThreshold = 7;

    public $messageText = '';

    public $selectedAttemptId = null;

    public $feedbackText = '';

    public $gradeScore = 0;

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedCourseFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function allStudentsEnrolled()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return User::whereHas('inscriptions', fn ($q) => $q->whereIn('cours_id', $courseIds))->count();
    }

    #[Computed]
    public function activeStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return User::whereHas('inscriptions', fn ($q) => $q->whereIn('cours_id', $courseIds))
            ->where('updated_at', '>', now()->subDays($this->inactiveDaysThreshold))
            ->count();
    }

    #[Computed]
    public function strugglingStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return User::whereHas('inscriptions', fn ($q) => $q->whereIn('cours_id', $courseIds)
            ->where('progress', '<', 30))
            ->count();
    }

    #[Computed]
    public function completedStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return User::whereHas('inscriptions', fn ($q) => $q->whereIn('cours_id', $courseIds)
            ->where('progress', '=', 100))
            ->count();
    }

    #[Computed]
    public function averageCompletion()
    {
        $courseIds = auth()->user()->cours()->pluck('id');
        $avg = Inscription::whereIn('cours_id', $courseIds)->avg('progress') ?? 0;

        return round($avg);
    }

    #[Computed]
    public function students()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return User::whereHas('inscriptions', fn ($q) => $q->whereIn('cours_id', $courseIds))
            ->when($this->filter !== 'tous', fn ($q) => match ($this->filter) {
                'actifs' => $q->where('updated_at', '>', now()->subDays($this->inactiveDaysThreshold)),
                'inactifs' => $q->where('updated_at', '<=', now()->subDays($this->inactiveDaysThreshold)),
                'difficulte' => $q->whereHas('inscriptions', fn ($sq) => $sq->where('progress', '<', 30)),
                'termines' => $q->whereHas('inscriptions', fn ($sq) => $sq->where('progress', '=', 100)),
            }
            )
            ->when($this->courseFilter, fn ($q) => $q->whereHas('inscriptions', fn ($sq) => $sq->where('cours_id', $this->courseFilter)))
            ->when($this->searchQuery, fn ($q) => $q->where(function ($sq) {
                $sq->where('name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('email', 'like', "%{$this->searchQuery}%");
            }))
            ->with('inscriptions.cours')
            ->orderByDesc($this->sortBy === 'recent' ? 'created_at' : 'updated_at')
            ->paginate(15);
    }

    #[Computed]
    public function selectedStudentDetail()
    {
        if (! $this->selectedStudentId) {
            return null;
        }

        return User::find($this->selectedStudentId)
            ->load('inscriptions.cours');
    }

    #[Computed]
    public function courses()
    {
        return auth()->user()->cours()->pluck('title', 'id');
    }

    #[Computed]
    public function pendingSubmissions()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        $query = QuizAttempt::whereHas('quiz', fn ($q) => $q->whereIn('cours_id', $courseIds))
            ->with('user', 'quiz.cours')
            ->latest('updated_at');

        if (Schema::hasColumn('quiz_attempts', 'is_graded')) {
            $query->where('is_graded', false);
        } else {
            $query->where('status', 'completed');
        }

        return $query->limit(10)->get();
    }

    #[Computed]
    public function studentActivity()
    {
        if (! $this->selectedStudentId) {
            return [];
        }

        $student = User::find($this->selectedStudentId);
        if (! $student) {
            return [];
        }

        // Get 7-day activity by counting daily updates for this student's inscriptions
        $activity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $nextDate = $date->copy()->endOfDay();

            $count = Inscription::where('user_id', $this->selectedStudentId)
                ->whereBetween('updated_at', [$date, $nextDate])
                ->count();

            // Convert to percentage (0-100)
            $percent = min(($count * 20), 100);
            $activity[] = max(20, $percent);
        }

        return $activity;
    }

    public function selectStudent($id)
    {
        $this->selectedStudentId = $id;
    }

    public function sendMessageToSelectedStudent()
    {
        if (! $this->selectedStudentId || trim($this->messageText) === '') {
            return;
        }

        DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedStudentId,
            'content' => trim($this->messageText),
            'is_read' => false,
        ]);

        $this->messageText = '';
        session()->flash('success', 'Message envoyé à l’étudiant.');
    }

    public function sendReminder($studentId)
    {
        $student = User::find($studentId);
        if (! $student) {
            return;
        }

        DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $student->id,
            'content' => 'Bonjour ! Nous avons remarqué une baisse d’activité. Reprenez votre progression quand vous êtes prêt.',
            'is_read' => false,
        ]);

        session()->flash('success', 'Relance envoyée à '.$student->name.'.');
    }

    public function startGrading($attemptId)
    {
        $attempt = QuizAttempt::find($attemptId);
        if (! $attempt) {
            return;
        }

        $this->selectedAttemptId = $attempt->id;
        $this->gradeScore = (int) ($attempt->score_percent ?? 0);
        $this->feedbackText = (string) ($attempt->grader_comment ?? '');
    }

    public function submitGrade()
    {
        if (! $this->selectedAttemptId) {
            return;
        }

        $attempt = QuizAttempt::find($this->selectedAttemptId);
        if (! $attempt) {
            return;
        }

        $payload = [
            'score' => $this->gradeScore,
            'status' => 'completed',
        ];

        if (Schema::hasColumn('quiz_attempts', 'is_graded')) {
            $payload['is_graded'] = true;
        }
        if (Schema::hasColumn('quiz_attempts', 'grader_comment')) {
            $payload['grader_comment'] = $this->feedbackText;
        }
        if (Schema::hasColumn('quiz_attempts', 'graded_at')) {
            $payload['graded_at'] = now();
        }

        $attempt->update($payload);

        $this->selectedAttemptId = null;
        $this->feedbackText = '';
        $this->gradeScore = 0;
        session()->flash('success', 'Notation et feedback enregistrés.');
    }

    public function render()
    {
        return view('livewire.formateur.mes-etudiants');
    }
}
