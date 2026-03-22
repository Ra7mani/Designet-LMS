<?php

namespace App\Livewire\Etudiant;

use App\Enums\EnrollStatus;
use App\Models\Certificat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;

class Profil extends Component
{
    use WithFileUploads;

    public $editMode = false;

    // Profile fields
    #[Rule('required|string|max:255')]
    public $firstName = '';

    #[Rule('required|string|max:255')]
    public $lastName = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('nullable|string|max:20')]
    public $phone = '';

    #[Rule('nullable|string|max:255')]
    public $location = '';

    #[Rule('nullable|string|max:255')]
    public $professional_objective = '';

    #[Rule('nullable|string|max:2000')]
    public $bio = '';

    #[Rule('nullable|url|max:500')]
    public $linkedin_url = '';

    #[Rule('nullable|url|max:500')]
    public $github_url = '';

    #[Rule('nullable|url|max:500')]
    public $portfolio_url = '';

    // File upload
    #[Rule('nullable|image|max:2048|mimes:jpg,jpeg,png,webp')]
    public $avatar;

    public $avatarPreview = '';
    public $avatarUpdated = false;

    // Skills
    #[Rule('nullable|string|min:2|max:50')]
    public $skillInput = '';

    public $selectedSkills = [];

    #[On('refreshProfile')]
    public function refreshProfile()
    {
        // Livewire will automatically refresh the render() method
    }

    public function mount()
    {
        $user = auth()->user();
        $this->firstName = collect(explode(' ', $user->name))->first() ?? '';
        $this->lastName = collect(explode(' ', $user->name))->last() ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->location = $user->location ?? '';
        $this->professional_objective = $user->professional_objective ?? '';
        $this->bio = $user->bio ?? '';
        $this->linkedin_url = $user->linkedin_url ?? '';
        $this->github_url = $user->github_url ?? '';
        $this->portfolio_url = $user->portfolio_url ?? '';
        $this->selectedSkills = $user->getSkills();

        if ($user->avatar_path) {
            $this->avatarPreview = asset('storage/' . $user->avatar_path);
        }
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
        if ($this->editMode) {
            $this->dispatch('scroll-to-edit');
        }
    }

    // Auto-save methods for each field
    public function updatedFirstName()
    {
        $this->updateProfile();
    }

    public function updatedLastName()
    {
        $this->updateProfile();
    }

    public function updatedEmail()
    {
        $this->updateProfile();
    }

    public function updatedPhone()
    {
        $this->updateProfile();
    }

    public function updatedLocation()
    {
        $this->updateProfile();
    }

    public function updatedProfessional_objective()
    {
        $this->updateProfile();
    }

    public function updatedBio()
    {
        $this->updateProfile();
    }

    public function updatedLinkedin_url()
    {
        $this->updateProfile();
    }

    public function updatedGithub_url()
    {
        $this->updateProfile();
    }

    public function updatedPortfolio_url()
    {
        $this->updateProfile();
    }

    public function updateProfile()
    {
        $user = auth()->user();

        // Custom validation with dynamic rules
        $this->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'professional_objective' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'linkedin_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
            'portfolio_url' => 'nullable|url|max:500',
        ]);

        $validated = [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'professional_objective' => $this->professional_objective,
            'bio' => $this->bio,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
            'portfolio_url' => $this->portfolio_url,
        ];

        $validated['name'] = $this->firstName . ' ' . $this->lastName;

        try {
            $user->update($validated);
            $this->dispatch('notify', message: '✅ Profil mis à jour avec succès');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la mise à jour');
        }
    }

    public function updatedAvatar()
    {
        if ($this->avatar) {
            $this->validate(['avatar' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp']);

            $user = auth()->user();

            // Delete old avatar
            if ($user->avatar_path && file_exists(storage_path('app/public/' . $user->avatar_path))) {
                unlink(storage_path('app/public/' . $user->avatar_path));
            }

            // Store new avatar
            $path = $this->avatar->store('avatars', 'public');
            $user->update(['avatar_path' => $path]);

            // Force refresh user data in session
            auth()->setUser($user->fresh());

            $this->avatarPreview = asset('storage/' . $path);
            $this->avatarUpdated = true;
            $this->avatar = null;

            $this->dispatch('notify', message: '📷 Photo de profil mise à jour');
            $this->dispatch('avatar-updated');
        }
    }

    public function addSkill()
    {
        $this->validate(['skillInput' => 'required|string|min:2|max:50']);

        if (count($this->selectedSkills) >= 12) {
            $this->dispatch('notify', message: '⚠️ Maximum 12 compétences autorisées');
            return;
        }

        if (!in_array($this->skillInput, $this->selectedSkills)) {
            $this->selectedSkills[] = $this->skillInput;
            auth()->user()->update(['skills_json' => $this->selectedSkills]);
            $this->skillInput = '';
            $this->dispatch('notify', message: '✅ Compétence ajoutée');
        } else {
            $this->dispatch('notify', message: '⚠️ Cette compétence existe déjà');
        }
    }

    public function removeSkill($index)
    {
        array_splice($this->selectedSkills, $index, 1);
        auth()->user()->update(['skills_json' => $this->selectedSkills]);
        $this->dispatch('notify', message: '🗑️ Compétence supprimée');
    }

    public function render()
    {
        $user = auth()->user();

        $inscriptions = $user->inscriptions()
            ->with(['cours.chapitres.lecons', 'cours.categorie', 'cours.formateur', 'certificat.inscription.cours', 'badge'])
            ->latest()
            ->get();

        $badges = $inscriptions->pluck('badge')->filter();

        // Charge tous les certificats liés à l'utilisateur, indépendamment du statut
        $certificats = Certificat::whereHas('inscription', function($query) use ($user) {
            $query->where('etudiant_id', $user->id);
        })
        ->with('inscription.cours')
        ->latest()
        ->get();

        $totalXp = $inscriptions->count() * 100
            + $inscriptions->where('status', EnrollStatus::Completed)->count() * 200;

        $level = floor($totalXp / 500) + 1;
        $xpInLevel = $totalXp % 500;
        $xpPercent = $level > 0 ? ($xpInLevel / 500) * 100 : 0;

        $profileCompleteness = $user->profileCompleteness();

        return view('livewire.etudiant.profil', [
            'user' => $user,
            'inscriptions' => $inscriptions,
            'badges' => $badges,
            'certificats' => $certificats,
            'totalXp' => $totalXp,
            'level' => $level,
            'xpInLevel' => $xpInLevel,
            'xpPercent' => $xpPercent,
            'profileCompleteness' => $profileCompleteness,
        ])->layout('layouts.etudiant');
    }
}

