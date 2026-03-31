<?php

namespace App\Livewire\Etudiant;

use App\Models\Cours;
use App\Models\Inscription;
use Livewire\Component;

class InscriptionCours extends Component
{
    public Cours $cours;

    public bool $dejaInscrit = false;

    public function mount(Cours $cours): void
    {
        $this->cours = $cours;
        $this->dejaInscrit = Inscription::where('etudiant_id', auth()->id())
            ->where('cours_id', $cours->id)
            ->exists();
    }

    public function inscrire(): void
    {
        if ($this->dejaInscrit) {
            return;
        }

        Inscription::create([
            'etudiant_id' => auth()->id(),
            'cours_id' => $this->cours->id,
            'enrolled_at' => now(),
            'progress' => 0,
            'status' => 'active',
        ]);

        $this->dejaInscrit = true;

        session()->flash('success', 'Inscription réussie !');
    }

    public function render()
    {
        return view('livewire.etudiant.inscription-cours');
    }
}
