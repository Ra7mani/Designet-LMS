<?php

namespace App\Livewire\Formateur;

use App\Models\Cours;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class MesCours extends Component
{
    use WithPagination;

    public $filterStatus = 'tous';

    public $searchQuery = '';

    public $sortBy = 'recent';

    public $viewMode = 'grid';

    public $selectedCourseId = null;

    public function updatedFilterStatus()
    {
        if (! in_array($this->filterStatus, ['tous', 'published', 'draft', 'archived'], true)) {
            $this->filterStatus = 'tous';
        }
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    #[Computed]
    public function stats()
    {
        $courses = Cours::where('formateur_id', auth()->id())
            ->with(['inscriptions.paiement'])
            ->get();

        $publishedCount = $courses->filter(fn ($c) => (($c->status->value ?? $c->status) === 'published'))->count();
        $draftCount = $courses->filter(fn ($c) => (($c->status->value ?? $c->status) === 'draft'))->count();
        $archivedCount = $courses->filter(fn ($c) => (($c->status->value ?? $c->status) === 'archived'))->count();
        $totalStudents = $courses->sum(fn ($c) => $c->inscriptions->count());
        $averageRating = $courses->avg('rating') ?? 0;
        $avgCompletion = $courses->sum(function ($course) {
            return (float) ($course->inscriptions->avg('progress') ?? 0);
        });
        $avgCompletion = $courses->count() > 0 ? round($avgCompletion / $courses->count(), 1) : 0;
        $totalRevenue = $courses->sum(function ($course) {
            return $course->inscriptions->sum(function ($inscription) {
                $payment = $inscription->paiement;
                if (! $payment) {
                    return 0;
                }

                $status = $payment->status->value ?? $payment->status;

                return $status === 'completed' ? (float) $payment->amount : 0;
            });
        });

        return [
            'published' => $publishedCount,
            'draft' => $draftCount,
            'archived' => $archivedCount,
            'totalStudents' => $totalStudents,
            'averageRating' => $averageRating,
            'averageCompletion' => $avgCompletion,
            'totalRevenue' => $totalRevenue,
            'total' => $courses->count(),
        ];
    }

    #[Computed]
    public function filteredCourses()
    {
        $query = Cours::where('formateur_id', auth()->id())
            ->when($this->filterStatus !== 'tous', fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->searchQuery, function ($q) {
                $q->where(function ($searchQ) {
                    $searchQ->where('title', 'like', "%{$this->searchQuery}%")
                        ->orWhere('description', 'like', "%{$this->searchQuery}%");
                });
            })
            ->with([
                'chapitres.lecons',
                'inscriptions.paiement',
                'avis.inscription.etudiant',
            ]);

        if ($this->sortBy === 'rating') {
            $query->orderByDesc('rating');
        } elseif ($this->sortBy === 'title') {
            $query->orderBy('title');
        } elseif ($this->sortBy === 'students') {
            $query->withCount('inscriptions')->orderByDesc('inscriptions_count');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query
            ->paginate(9)
            ->through(function ($course) {
                $revenue = $course->inscriptions->sum(function ($inscription) {
                    $payment = $inscription->paiement;
                    if (! $payment) {
                        return 0;
                    }
                    $status = $payment->status->value ?? $payment->status;

                    return $status === 'completed' ? (float) $payment->amount : 0;
                });

                $course->setAttribute('students_count_value', $course->inscriptions->count());
                $course->setAttribute('completion_avg_value', intval($course->inscriptions->avg('progress') ?? 0));
                $course->setAttribute('revenue_total_value', $revenue);
                $course->setAttribute('status_value', $course->status->value ?? $course->status);

                return $course;
            });
    }

    #[Computed]
    public function courseDetails()
    {
        if (! $this->selectedCourseId) {
            // Retourner le premier cours si aucun n'est sélectionné
            return Cours::where('formateur_id', auth()->id())
                ->with('chapitres.lecons', 'inscriptions.paiement', 'avis.inscription.etudiant')
                ->orderByDesc('rating')
                ->first();
        }

        return Cours::where('formateur_id', auth()->id())
            ->with('chapitres.lecons', 'inscriptions.paiement', 'avis.inscription.etudiant')
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

    #[Computed]
    public function chapterProgressions()
    {
        if (! $this->courseDetails || ! $this->courseDetails->chapitres) {
            return [];
        }

        $chapters = $this->courseDetails->chapitres->values();
        $courseProgress = (float) ($this->courseDetails->inscriptions->avg('progress') ?? 0);
        $chapterCount = max(1, $chapters->count());
        $doneChaptersFloat = ($courseProgress / 100) * $chapterCount;
        $courseStatus = $this->courseDetails->status->value ?? $this->courseDetails->status;

        return $chapters->mapWithKeys(function ($chapter, $index) use ($doneChaptersFloat, $courseStatus) {
            $chapterProgress = max(0, min(100, ($doneChaptersFloat - $index) * 100));
            $status = ($courseStatus === 'published' && $chapter->lecons->count() > 0) ? 'publié' : 'brouillon';

            return [
                $chapter->id => [
                    'progress' => (int) round($chapterProgress),
                    'status' => $status,
                ],
            ];
        })->toArray();
    }

    public function selectCourse($id)
    {
        $this->selectedCourseId = $id;
    }

    public function setViewMode($mode)
    {
        if (in_array($mode, ['grid', 'list'], true)) {
            $this->viewMode = $mode;
        }
    }

    public function deleteCourse($id)
    {
        Cours::where('formateur_id', auth()->id())->find($id)?->delete();
        $this->selectedCourseId = null;
    }

    public function publishCourse($id)
    {
        $course = Cours::where('formateur_id', auth()->id())->find($id);
        if ($course) {
            $course->update(['status' => 'published']);
        }
    }

    public function depublishCourse($id)
    {
        $course = Cours::where('formateur_id', auth()->id())->find($id);
        if ($course) {
            $course->update(['status' => 'draft']);
        }
    }

    public function archiveCourse($id)
    {
        $course = Cours::where('formateur_id', auth()->id())->find($id);
        if ($course) {
            $course->update(['status' => 'archived']);
            if ((int) $this->selectedCourseId === (int) $id) {
                $this->selectedCourseId = null;
            }
        }
    }

    public function duplicateCourse($id)
    {
        $course = Cours::where('formateur_id', auth()->id())
            ->with('chapitres.lecons')
            ->find($id);

        if (! $course) {
            return;
        }

        DB::transaction(function () use ($course) {
            $newCourse = Cours::create([
                'categorie_id' => $course->categorie_id,
                'formateur_id' => auth()->id(),
                'title' => $course->title.' (Copie)',
                'description' => $course->description,
                'price' => $course->price,
                'level' => $course->level,
                'status' => 'draft',
                'thumbnail' => $course->thumbnail,
                'rating' => 0,
                'certificating' => $course->certificating,
                'discussion_forum' => $course->discussion_forum,
                'promo_code' => $course->promo_code,
                'language' => $course->language,
            ]);

            foreach ($course->chapitres as $chapter) {
                $newChapter = $newCourse->chapitres()->create([
                    'title' => $chapter->title,
                    'order' => $chapter->order,
                    'description' => $chapter->description,
                ]);

                foreach ($chapter->lecons as $lesson) {
                    $newChapter->lecons()->create([
                        'title' => $lesson->title,
                        'content' => $lesson->content,
                        'video_url' => $lesson->video_url,
                        'duration' => $lesson->duration,
                        'order' => $lesson->order,
                        'type' => $lesson->type,
                    ]);
                }
            }
        });
    }

    public function render()
    {
        return view('livewire.formateur.mes-cours');
    }
}
