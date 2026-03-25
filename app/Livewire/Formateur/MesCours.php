<?php

namespace App\Livewire\Formateur;

use App\Models\Cours;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class MesCours extends Component
{
    use WithPagination;

    public $filterStatus = 'tous';
    public $searchQuery = '';
    public $sortBy = 'recent';
    public $selectedCourseId = null;

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    #[Computed]
    public function stats()
    {
        $courses = Cours::where('formateur_id', auth()->id())->get();
        $publishedCount = $courses->where('status', 'published')->count();
        $draftCount = $courses->where('status', 'draft')->count();
        $totalStudents = $courses->sum(fn($c) => $c->inscriptions->count());
        $averageRating = $courses->avg('rating') ?? 0;
        $pendingAssignments = $courses->sum(fn($c) => $c->quizzes->count() ?? 0);

        return [
            'published' => $publishedCount,
            'draft' => $draftCount,
            'totalStudents' => $totalStudents,
            'averageRating' => $averageRating,
            'pendingAssignments' => $pendingAssignments,
            'total' => $courses->count(),
        ];
    }

    #[Computed]
    public function filteredCourses()
    {
        return Cours::where('formateur_id', auth()->id())
            ->when($this->filterStatus !== 'tous', fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->searchQuery, fn($q) => $q->where('title', 'like', "%{$this->searchQuery}%"))
            ->orderByDesc($this->sortBy === 'recent' ? 'created_at' : 'rating')
            ->with('chapitres', 'inscriptions', 'avis')
            ->paginate(9);
    }

    #[Computed]
    public function courseDetails()
    {
        if (!$this->selectedCourseId) {
            // Retourner le premier cours si aucun n'est sélectionné
            return Cours::where('formateur_id', auth()->id())
                ->with('chapitres.lecons', 'inscriptions', 'avis')
                ->orderByDesc('rating')
                ->first();
        }

        return Cours::where('formateur_id', auth()->id())
            ->with('chapitres.lecons', 'inscriptions', 'avis')
            ->find($this->selectedCourseId);
    }

    #[Computed]
    public function chapterCompletionPercentages()
    {
        $completion = [];
        if ($this->courseDetails && $this->courseDetails->chapitres) {
            foreach ($this->courseDetails->chapitres as $index => $chapter) {
                // Calculate completion based on inscriptions progress
                // Use random percentage for demo, but base it on course progress
                $avgProgress = $this->courseDetails->inscriptions->avg('progress') ?? 0;
                // Add variance by chapter position
                $variance = ($index * 5) % 30;
                $percent = min(98, max(40, $avgProgress + $variance));
                $completion[$chapter->id] = intval($percent);
            }
        }
        return $completion;
    }

    public function selectCourse($id)
    {
        $this->selectedCourseId = $id;
    }

    public function deleteCourse($id)
    {
        Cours::where('formateur_id', auth()->id())->find($id)?->delete();
        $this->selectedCourseId = null;
    }

    public function publishCourse($id)
    {
        Cours::where('formateur_id', auth()->id())
            ->find($id)
            ->update(['status' => 'published']);
    }

    public function render()
    {
        return view('livewire.formateur.mes-cours');
    }
}

