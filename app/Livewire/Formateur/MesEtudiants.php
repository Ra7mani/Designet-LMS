<?php

namespace App\Livewire\Formateur;

use App\Models\User;
use App\Models\Inscription;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Carbon\Carbon;

#[Layout('layouts.formateur')]
class MesEtudiants extends Component
{
    use WithPagination;

    public $filter = 'tous';
    public $courseFilter = null;
    public $sortBy = 'recent';
    public $searchQuery = '';
    public $selectedStudentId = null;

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
        return User::whereHas('inscriptions', fn($q) => $q->whereIn('cours_id', $courseIds))->count();
    }

    #[Computed]
    public function activeStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');
        return User::whereHas('inscriptions', fn($q) => $q->whereIn('cours_id', $courseIds))
            ->where('updated_at', '>', now()->subDays(7))
            ->count();
    }

    #[Computed]
    public function strugglingStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');
        return User::whereHas('inscriptions', fn($q) => $q->whereIn('cours_id', $courseIds)
            ->where('progress', '<', 30))
            ->count();
    }

    #[Computed]
    public function completedStudents()
    {
        $courseIds = auth()->user()->cours()->pluck('id');
        return User::whereHas('inscriptions', fn($q) => $q->whereIn('cours_id', $courseIds)
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

        return User::whereHas('inscriptions', fn($q) => $q->whereIn('cours_id', $courseIds))
            ->when($this->filter !== 'tous', fn($q) =>
                match($this->filter) {
                    'actifs' => $q->where('updated_at', '>', now()->subDays(7)),
                    'difficulte' => $q->whereHas('inscriptions', fn($sq) => $sq->where('progress', '<', 30)),
                    'termines' => $q->whereHas('inscriptions', fn($sq) => $sq->where('progress', '=', 100)),
                }
            )
            ->when($this->courseFilter, fn($q) => $q->whereHas('inscriptions', fn($sq) => $sq->where('cours_id', $this->courseFilter)))
            ->when($this->searchQuery, fn($q) => $q->where('name', 'like', "%{$this->searchQuery}%"))
            ->with('inscriptions.cours')
            ->orderByDesc($this->sortBy === 'recent' ? 'created_at' : 'updated_at')
            ->paginate(15);
    }

    #[Computed]
    public function selectedStudentDetail()
    {
        if (!$this->selectedStudentId) return null;

        return User::find($this->selectedStudentId)
            ->load('inscriptions.cours');
    }

    #[Computed]
    public function courses()
    {
        return auth()->user()->cours()->pluck('title', 'id');
    }

    #[Computed]
    public function studentActivity()
    {
        if (!$this->selectedStudentId) return [];

        $student = User::find($this->selectedStudentId);
        if (!$student) return [];

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

    public function render()
    {
        return view('livewire.formateur.mes-etudiants');
    }
}
