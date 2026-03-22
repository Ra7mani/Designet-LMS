<?php

namespace App\Livewire\Etudiant;

use App\Models\Categorie;
use App\Models\Cours;
use Livewire\Component;
use Livewire\WithPagination;

class Catalogue extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categorie_id = '';
    public string $level = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategorieId(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $cours = Cours::query()
            ->where('status', 'published')
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%')
            )
            ->when($this->categorie_id, fn($q) =>
                $q->where('categorie_id', $this->categorie_id)
            )
            ->when($this->level, fn($q) =>
                $q->where('level', $this->level)
            )
            ->with(['categorie', 'formateur'])
            ->paginate(9);

        $categories = Categorie::all();

        return view('livewire.etudiant.catalogue', compact('cours', 'categories'));
    }
}