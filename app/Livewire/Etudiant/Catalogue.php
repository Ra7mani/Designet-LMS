<?php

namespace App\Livewire\Etudiant;

use App\Enums\CourseStatus;
use App\Models\Categorie;
use App\Models\Cours;
use App\Models\Favoris;
use Livewire\Component;
use Livewire\WithPagination;

class Catalogue extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categorie_id = '';
    public string $level = '';
    public bool $showFavorites = false;
    public array $userFavorites = [];

    public function mount(): void
    {
        $this->loadUserFavorites();
    }

    public function loadUserFavorites(): void
    {
        if (auth()->check()) {
            $this->userFavorites = auth()->user()
                ->favoris()
                ->pluck('cours_id')
                ->toArray();
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategorieId(): void
    {
        $this->resetPage();
    }

    public function updatingLevel(): void
    {
        $this->resetPage();
    }

    public function updatingShowFavorites(): void
    {
        $this->resetPage();
    }

    public function toggleFavorite(int $coursId): void
    {
        if (!auth()->check()) {
            session()->flash('error', 'Veuillez vous connecter pour ajouter des favoris.');
            return;
        }

        $favorite = Favoris::where('user_id', auth()->id())
            ->where('cours_id', $coursId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $this->userFavorites = array_filter($this->userFavorites, fn($id) => $id !== $coursId);
            session()->flash('success', 'Cours supprimé de vos favoris.');
        } else {
            Favoris::create([
                'user_id' => auth()->id(),
                'cours_id' => $coursId,
            ]);
            $this->userFavorites[] = $coursId;
            session()->flash('success', 'Cours ajouté à vos favoris !');
        }

        $this->dispatch('favorite-updated');
    }

    public function render()
    {
        $query = Cours::query()
            ->where('status', CourseStatus::Published)
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%')
            )
            ->when($this->showFavorites, fn($q) =>
                $q->whereIn('id', $this->userFavorites ?: [0])
            )
            ->when($this->categorie_id && !$this->showFavorites, fn($q) =>
                $q->where('categorie_id', $this->categorie_id)
            )
            ->when($this->level, fn($q) =>
                $q->where('level', $this->level)
            );

        $cours = $query
            ->with(['categorie', 'formateur', 'chapitres.lecons', 'inscriptions'])
            ->withCount('inscriptions')
            ->latest()
            ->paginate(12);

        $categories = Categorie::withCount('cours')->get();

        $totalCours = Cours::where('status', CourseStatus::Published)->count();
        $favorisCount = count($this->userFavorites);

        return view('livewire.etudiant.catalogue', [
            'cours' => $cours,
            'categories' => $categories,
            'totalCours' => $totalCours,
            'favorisCount' => $favorisCount,
        ])->layout('layouts.etudiant');
    }
}

