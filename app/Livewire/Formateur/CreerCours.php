<?php

namespace App\Livewire\Formateur;

use App\Models\Categorie;
use App\Models\Chapitre;
use App\Models\Cours;
use App\Models\Lecon;
use App\Models\Quiz;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.formateur')]
class CreerCours extends Component
{
    use WithFileUploads;

    public $courseId = null;

    public $step = 1;

    public $title = '';

    public $category_id = 0;

    public $language = 'Français';

    public $level = '';

    public $shortDescription = '';

    public $description = '';

    public $coverImage = null;

    public $coverImagePath = '';

    public $price = 0;

    public $promoCode = '';

    public $certificateEnabled = true;

    public $forumEnabled = true;

    public $chapters = [];

    public $selectedContentType = 'video';

    public $currency = 'EUR';

    public $formErrors = [];

    public $lessonVideoUploads = [];

    public $lessonResourceUploads = [];

    public $showStudentPreview = false;

    public $lastAutoSaveAt = null;

    public function mount($id = null)
    {
        if ($id) {
            $this->courseId = $id;
            $this->loadCourse($id);
        }
    }

    private function loadCourse($id)
    {
        $course = Cours::where('formateur_id', auth()->id())->find($id);
        if ($course) {
            $this->title = $course->title;
            $this->category_id = $course->categorie_id;
            $this->language = $course->language ?? 'Français';
            $this->level = $course->level;
            $this->shortDescription = $course->description;
            $this->description = $course->description;
            $this->price = $course->price;
            $this->promoCode = $course->promo_code ?? '';
            $this->certificateEnabled = $course->certificating ?? false;
            $this->forumEnabled = $course->discussion_forum ?? true;
            $this->coverImagePath = $course->thumbnail ?? '';
            $this->chapters = $course->chapitres->map(fn ($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'type' => $c->lecons->first()?->type ?? 'video',
                'quiz_id' => Schema::hasColumn('quizzes', 'chapitre_id')
                    ? Quiz::where('cours_id', $course->id)->where('chapitre_id', $c->id)->value('id')
                    : null,
                'lessons' => $c->lecons->map(fn ($l) => [
                    'id' => $l->id,
                    'title' => $l->title,
                    'type' => $l->type ?? 'video',
                    'content' => $l->content ?? '',
                    'video_url' => $l->video_url ?? '',
                    'resource_path' => Schema::hasColumn('lecons', 'resource_path') ? ($l->resource_path ?? '') : '',
                    'resource_name' => Schema::hasColumn('lecons', 'resource_name') ? ($l->resource_name ?? '') : '',
                ])->toArray(),
            ])->toArray();
        }
    }

    #[Computed]
    public function categoryName()
    {
        if ($this->category_id <= 0) {
            return 'Catégorie';
        }

        return Categorie::find($this->category_id)?->name ?? 'Catégorie';
    }

    public function nextStep()
    {
        $this->step = min(4, $this->step + 1);
    }

    public function previousStep()
    {
        $this->step = max(1, $this->step - 1);
    }

    public function setStep($stepNumber)
    {
        if ($stepNumber >= 1 && $stepNumber <= 4) {
            $this->step = $stepNumber;
        }
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function setContentType($type)
    {
        $this->selectedContentType = $type;
    }

    #[Computed]
    public function availableQuizzes()
    {
        if (! $this->courseId) {
            return collect();
        }

        return Quiz::where('cours_id', $this->courseId)->orderBy('title')->get();
    }

    #[Computed]
    public function publicationChecklist()
    {
        $hasTitle = trim($this->title) !== '';
        $hasCategory = (int) $this->category_id > 0;
        $hasLevel = trim($this->level) !== '';
        $hasDescription = trim($this->shortDescription) !== '';
        $hasCover = $this->coverImage || $this->coverImagePath;
        $hasChapter = count($this->chapters) > 0;
        $hasLesson = collect($this->chapters)->sum(fn ($c) => count($c['lessons'] ?? [])) > 0;
        $hasPrice = is_numeric($this->price);

        $items = [
            ['label' => 'Titre', 'done' => $hasTitle],
            ['label' => 'Catégorie', 'done' => $hasCategory],
            ['label' => 'Niveau', 'done' => $hasLevel],
            ['label' => 'Description', 'done' => $hasDescription],
            ['label' => 'Image couverture', 'done' => (bool) $hasCover],
            ['label' => 'Au moins 1 chapitre', 'done' => $hasChapter],
            ['label' => 'Au moins 1 leçon', 'done' => $hasLesson],
            ['label' => 'Prix défini', 'done' => $hasPrice],
        ];

        $doneCount = collect($items)->where('done', true)->count();
        $percent = (int) round(($doneCount / max(1, count($items))) * 100);

        return [
            'items' => $items,
            'done_count' => $doneCount,
            'total_count' => count($items),
            'percent' => $percent,
        ];
    }

    public function addChapter()
    {
        $this->chapters[] = [
            'id' => null,
            'title' => 'Nouveau Chapitre',
            'type' => $this->selectedContentType,
            'quiz_id' => null,
            'lessons' => [],
        ];
    }

    public function removeChapter($index)
    {
        unset($this->chapters[$index]);
        $this->chapters = array_values($this->chapters);
    }

    public function editChapter($index)
    {
        // For now, just focus on editing the title via wire:model
        // Future: could open a modal for more complex editing
    }

    public function reorderChapters($fromIndex, $toIndex)
    {
        $from = (int) $fromIndex;
        $to = (int) $toIndex;

        if (! isset($this->chapters[$from]) || ! isset($this->chapters[$to])) {
            return;
        }

        $item = $this->chapters[$from];
        array_splice($this->chapters, $from, 1);
        array_splice($this->chapters, $to, 0, [$item]);
        $this->chapters = array_values($this->chapters);
    }

    public function addLesson($chapterIndex, $type = null)
    {
        if (! isset($this->chapters[$chapterIndex])) {
            return;
        }

        $lessonType = $type ?: ($this->chapters[$chapterIndex]['type'] ?? 'video');
        $this->chapters[$chapterIndex]['lessons'][] = [
            'id' => null,
            'title' => 'Nouvelle leçon',
            'type' => $lessonType,
            'content' => '',
            'video_url' => '',
            'resource_path' => '',
            'resource_name' => '',
        ];
    }

    public function removeLesson($chapterIndex, $lessonIndex)
    {
        if (! isset($this->chapters[$chapterIndex]['lessons'][$lessonIndex])) {
            return;
        }

        unset($this->chapters[$chapterIndex]['lessons'][$lessonIndex]);
        $this->chapters[$chapterIndex]['lessons'] = array_values($this->chapters[$chapterIndex]['lessons']);
    }

    public function toggleStudentPreview()
    {
        $this->showStudentPreview = ! $this->showStudentPreview;
    }

    public function autoSaveDraft()
    {
        if (trim($this->title) === '' || (int) $this->category_id <= 0) {
            return;
        }

        $this->persistCourse('draft', false);
    }

    public function addQuiz()
    {
        if (! $this->courseId) {
            $this->saveDraft();
        }

        if (! $this->courseId) {
            return;
        }

        Quiz::create([
            'cours_id' => $this->courseId,
            'title' => 'Quiz '.now()->format('d/m H:i'),
            'duration' => 30,
            'passing_score' => 50,
            'max_attempts' => 3,
            'type' => 'quiz',
        ]);

        session()->flash('message', '📝 Quiz ajouté avec succès!');
    }

    public function addAssignment()
    {
        session()->flash('message', '🎓 Devoir ajouté avec succès!');
    }

    public function publishCourse()
    {
        $this->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'level' => 'required|string',
            'shortDescription' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'coverImage' => 'nullable|image|max:3072',
        ], [
            'title.required' => 'Le titre du cours est requis',
            'title.min' => 'Le titre doit contenir au moins 3 caractères',
            'category_id.required' => 'Veuillez sélectionner une catégorie',
            'category_id.min' => 'Catégorie invalide',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'level.required' => 'Veuillez sélectionner un niveau',
            'shortDescription.required' => 'La description est requise',
            'shortDescription.min' => 'La description doit contenir au moins 10 caractères',
            'price.required' => 'Le prix est requis',
            'price.numeric' => 'Le prix doit être un nombre',
        ]);

        $this->persistCourse('published', true);

        return redirect()->route('formateur.mes-cours');
    }

    public function saveDraft()
    {
        $this->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'level' => 'nullable|string',
            'shortDescription' => 'nullable|string|min:5',
            'price' => 'nullable|numeric|min:0',
            'coverImage' => 'nullable|image|max:3072',
        ], [
            'title.required' => 'Le titre du cours est requis',
            'title.min' => 'Le titre doit contenir au moins 3 caractères',
            'category_id.required' => 'Veuillez sélectionner une catégorie',
            'category_id.min' => 'Catégorie invalide',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
        ]);

        $this->persistCourse('draft', true);
    }

    private function persistCourse(string $status, bool $withFlash = true): void
    {
        $thumbnailPath = $this->coverImagePath;
        if ($this->coverImage) {
            $thumbnailPath = $this->coverImage->store('courses/covers', 'public');
            $this->coverImagePath = $thumbnailPath;
        }

        $data = [
            'formateur_id' => auth()->id(),
            'title' => $this->title,
            'categorie_id' => $this->category_id,
            'description' => $this->description ?: $this->shortDescription,
            'level' => $this->level,
            'price' => $this->price,
            'certificating' => $this->certificateEnabled,
            'discussion_forum' => $this->forumEnabled,
            'promo_code' => $this->promoCode,
            'language' => $this->language,
            'thumbnail' => $thumbnailPath,
            'status' => $status,
        ];

        $course = null;
        if ($this->courseId) {
            $course = Cours::where('formateur_id', auth()->id())->find($this->courseId);
            $course?->update($data);
        } else {
            $course = Cours::create($data);
            $this->courseId = $course->id;
        }

        if (! $course && $this->courseId) {
            $course = Cours::find($this->courseId);
        }

        if ($course) {
            $this->syncChaptersAndLessons($course);
        }

        $this->lastAutoSaveAt = now()->format('H:i:s');
        if ($withFlash) {
            session()->flash('message', $status === 'published'
                ? '🚀 Cours publié avec succès!'
                : '💾 Brouillon sauvegardé avec succès!');
        }
    }

    private function syncChaptersAndLessons(Cours $course): void
    {
        $existingChapterIds = [];

        foreach ($this->chapters as $chapterIndex => $chapterData) {
            $chapter = null;
            if (! empty($chapterData['id'])) {
                $chapter = Chapitre::where('cours_id', $course->id)->find($chapterData['id']);
            }

            if (! $chapter) {
                $chapter = new Chapitre(['cours_id' => $course->id]);
            }

            $chapter->title = $chapterData['title'] ?? ('Chapitre '.($chapterIndex + 1));
            $chapter->order = $chapterIndex;
            $chapter->description = null;
            $chapter->save();

            $this->chapters[$chapterIndex]['id'] = $chapter->id;
            $existingChapterIds[] = $chapter->id;

            $existingLessonIds = [];
            foreach (($chapterData['lessons'] ?? []) as $lessonIndex => $lessonData) {
                $lesson = null;
                if (! empty($lessonData['id'])) {
                    $lesson = Lecon::where('chapitre_id', $chapter->id)->find($lessonData['id']);
                }

                if (! $lesson) {
                    $lesson = new Lecon(['chapitre_id' => $chapter->id]);
                }

                $videoUpload = $this->lessonVideoUploads[$chapterIndex][$lessonIndex] ?? null;
                if ($videoUpload) {
                    $lessonData['video_url'] = $videoUpload->store('courses/videos', 'public');
                }

                $resourceUpload = $this->lessonResourceUploads[$chapterIndex][$lessonIndex] ?? null;
                if ($resourceUpload) {
                    $lessonData['resource_path'] = $resourceUpload->store('courses/resources', 'public');
                    $lessonData['resource_name'] = $resourceUpload->getClientOriginalName();
                }

                $lesson->title = $lessonData['title'] ?? ('Leçon '.($lessonIndex + 1));
                $lesson->content = $lessonData['content'] ?? '';
                $lesson->video_url = $lessonData['video_url'] ?? '';
                $lesson->duration = 0;
                $lesson->order = $lessonIndex;
                $lesson->type = $lessonData['type'] ?? 'video';
                if (Schema::hasColumn('lecons', 'resource_path')) {
                    $lesson->resource_path = $lessonData['resource_path'] ?? '';
                }
                if (Schema::hasColumn('lecons', 'resource_name')) {
                    $lesson->resource_name = $lessonData['resource_name'] ?? '';
                }
                $lesson->save();

                $this->chapters[$chapterIndex]['lessons'][$lessonIndex]['id'] = $lesson->id;
                $this->chapters[$chapterIndex]['lessons'][$lessonIndex]['video_url'] = $lesson->video_url;
                $this->chapters[$chapterIndex]['lessons'][$lessonIndex]['resource_path'] = Schema::hasColumn('lecons', 'resource_path') ? ($lesson->resource_path ?? '') : '';
                $this->chapters[$chapterIndex]['lessons'][$lessonIndex]['resource_name'] = Schema::hasColumn('lecons', 'resource_name') ? ($lesson->resource_name ?? '') : '';
                $existingLessonIds[] = $lesson->id;
            }

            Lecon::where('chapitre_id', $chapter->id)
                ->whereNotIn('id', $existingLessonIds ?: [0])
                ->delete();

            if (! empty($chapterData['quiz_id']) && Schema::hasColumn('quizzes', 'chapitre_id')) {
                Quiz::where('cours_id', $course->id)
                    ->where('id', $chapterData['quiz_id'])
                    ->update(['chapitre_id' => $chapter->id]);
            }
        }

        Chapitre::where('cours_id', $course->id)
            ->whereNotIn('id', $existingChapterIds ?: [0])
            ->delete();

        $this->lessonVideoUploads = [];
        $this->lessonResourceUploads = [];
    }

    public function coverUrl(): string
    {
        if ($this->coverImagePath) {
            return Storage::url($this->coverImagePath);
        }

        return '';
    }

    public function render()
    {
        return view('livewire.formateur.creer-cours', [
            'categories' => Categorie::all(),
        ]);
    }
}
