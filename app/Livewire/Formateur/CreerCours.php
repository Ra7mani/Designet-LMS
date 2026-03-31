<?php

namespace App\Livewire\Formateur;

use App\Models\Cours;
use App\Models\Chapitre;
use App\Models\Lecon;
use App\Models\Categorie;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
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
    public $price = 0;
    public $promoCode = '';
    public $certificateEnabled = true;
    public $forumEnabled = true;
    public $chapters = [];
    public $selectedContentType = 'video';
    public $currency = 'EUR';
    public $formErrors = [];

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
            $this->price = $course->price;
            $this->promoCode = $course->promo_code ?? '';
            $this->certificateEnabled = $course->certificating ?? false;
            $this->forumEnabled = $course->discussion_forum ?? true;
            $this->chapters = $course->chapitres->map(fn($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'type' => 'video',
                'lessons' => $c->lecons->toArray(),
            ])->toArray();
        }
    }

    #[Computed]
    public function categoryName()
    {
        if ($this->category_id <= 0) return 'Catégorie';
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

    public function addChapter()
    {
        $this->chapters[] = [
            'id' => null,
            'title' => 'Nouveau Chapitre',
            'type' => $this->selectedContentType,
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

    public function addQuiz()
    {
        session()->flash('message', '📝 Quiz ajouté avec succès!');
    }

    public function addAssignment()
    {
        session()->flash('message', '🎓 Devoir ajouté avec succès!');
    }

    public function publishCourse()
    {
        // Validate form data
        $validated = $this->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'level' => 'required|string',
            'shortDescription' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
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

        $data = [
            'formateur_id' => auth()->id(),
            'title' => $this->title,
            'categorie_id' => $this->category_id,
            'description' => $this->shortDescription,
            'level' => $this->level,
            'price' => $this->price,
            'certificating' => $this->certificateEnabled,
            'discussion_forum' => $this->forumEnabled,
            'status' => 'published',
        ];

        if ($this->courseId) {
            Cours::where('formateur_id', auth()->id())->find($this->courseId)->update($data);
            session()->flash('message', '✏️ Cours modifié avec succès!');
        } else {
            Cours::create($data);
            session()->flash('message', '🚀 Cours publié avec succès!');
        }

        return redirect()->route('formateur.mes-cours');
    }

    public function saveDraft()
    {
        // Validate form data
        $validated = $this->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'level' => 'nullable|string',
            'shortDescription' => 'nullable|string|min:5',
            'price' => 'nullable|numeric|min:0',
        ], [
            'title.required' => 'Le titre du cours est requis',
            'title.min' => 'Le titre doit contenir au moins 3 caractères',
            'category_id.required' => 'Veuillez sélectionner une catégorie',
            'category_id.min' => 'Catégorie invalide',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
        ]);

        $data = [
            'formateur_id' => auth()->id(),
            'title' => $this->title,
            'categorie_id' => $this->category_id,
            'description' => $this->shortDescription,
            'level' => $this->level,
            'price' => $this->price,
            'certificating' => $this->certificateEnabled,
            'discussion_forum' => $this->forumEnabled,
            'status' => 'draft',
        ];

        if ($this->courseId) {
            Cours::where('formateur_id', auth()->id())->find($this->courseId)->update($data);
            session()->flash('message', '💾 Brouillon modifié avec succès!');
        } else {
            Cours::create($data);
            session()->flash('message', '💾 Brouillon sauvegardé avec succès!');
        }
    }

    public function render()
    {
        return view('livewire.formateur.creer-cours', [
            'categories' => Categorie::all(),
        ]);
    }
}
