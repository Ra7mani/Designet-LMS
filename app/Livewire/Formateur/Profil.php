<?php

namespace App\Livewire\Formateur;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.formateur')]
class Profil extends Component
{
    use WithFileUploads;

    public $editMode = false;

    public $firstName = '';

    public $lastName = '';

    public $email = '';

    public $phone = '';

    public $location = '';

    public $professionalObjective = '';

    public $portfolioUrl = '';

    public $biography = '';

    public $skills = [];

    public $skillInput = '';

    public $linkedinUrl = '';

    public $githubUrl = '';

    public $avatar;

    public $avatarPreview = '';

    public function mount()
    {
        $user = auth()->user();
        $nameParts = preg_split('/\s+/', trim((string) $user->name)) ?: [];
        $this->firstName = $nameParts[0] ?? '';
        $this->lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->location = $user->location ?? '';
        $this->professionalObjective = $user->professional_objective ?? '';
        $this->portfolioUrl = $user->portfolio_url ?? '';
        $this->biography = $user->bio ?? '';
        $this->skills = $user->getSkills() ?? [];
        $this->linkedinUrl = $user->linkedin_url ?? '';
        $this->githubUrl = $user->github_url ?? '';
        $this->avatarPreview = $user->avatar_path ? asset('storage/'.$user->avatar_path) : '';
    }

    public function toggleEditMode()
    {
        $this->editMode = ! $this->editMode;
    }

    public function saveProfile()
    {
        $this->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.auth()->id(),
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'professionalObjective' => 'nullable|string|max:255',
            'portfolioUrl' => 'nullable|url|max:500',
            'biography' => 'nullable|string|max:2000',
            'linkedinUrl' => 'nullable|url|max:500',
            'githubUrl' => 'nullable|url|max:500',
        ]);

        $fullName = trim($this->firstName.' '.$this->lastName);

        auth()->user()->update([
            'name' => $fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'professional_objective' => $this->professionalObjective,
            'portfolio_url' => $this->portfolioUrl,
            'bio' => $this->biography,
            'linkedin_url' => $this->linkedinUrl,
            'github_url' => $this->githubUrl,
        ]);
        $this->editMode = false;
        $this->dispatch('notify', message: '✅ Profil mis à jour');
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
        ]);

        $user = auth()->user();
        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $this->avatar->store('avatars', 'public');
        $user->update(['avatar_path' => $path]);
        auth()->setUser($user->fresh());

        $this->avatarPreview = asset('storage/'.$path);
        $this->avatar = null;
        $this->dispatch('notify', message: '📷 Photo de profil mise à jour');
    }

    public function addSkill()
    {
        $this->validate(['skillInput' => 'required|string|min:2|max:50']);
        if ($this->skillInput && ! in_array($this->skillInput, $this->skills, true)) {
            $this->skills[] = $this->skillInput;
            auth()->user()->update(['skills_json' => $this->skills]);
            $this->skillInput = '';
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
        auth()->user()->update(['skills_json' => $this->skills]);
    }

    public function render()
    {
        return view('livewire.formateur.profil');
    }
}
