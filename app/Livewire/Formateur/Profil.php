<?php

namespace App\Livewire\Formateur;

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

    public $city = '';

    public $country = '';

    public $portfolioUrl = '';

    public $biography = '';

    public $skills = [];

    public $skillInput = '';

    public $linkedinUrl = '';

    public $behanceUrl = '';

    public $dribbbleUrl = '';

    public function mount()
    {
        $user = auth()->user();
        $this->firstName = $user->first_name ?? '';
        $this->lastName = $user->last_name ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->city = $user->city ?? '';
        $this->country = $user->country ?? '';
        $this->portfolioUrl = $user->portfolio_url ?? '';
        $this->biography = $user->bio ?? '';
        $this->skills = $user->getSkills() ?? [];
        $this->linkedinUrl = $user->linkedin_url ?? '';
        $this->behanceUrl = $user->behance_url ?? '';
        $this->dribbbleUrl = $user->dribbble_url ?? '';
    }

    public function toggleEditMode()
    {
        $this->editMode = ! $this->editMode;
    }

    public function saveProfile()
    {
        auth()->user()->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'country' => $this->country,
            'portfolio_url' => $this->portfolioUrl,
            'bio' => $this->biography,
            'linkedin_url' => $this->linkedinUrl,
            'behance_url' => $this->behanceUrl,
            'dribbble_url' => $this->dribbbleUrl,
        ]);
        $this->editMode = false;
    }

    public function addSkill()
    {
        if ($this->skillInput) {
            $this->skills[] = $this->skillInput;
            auth()->user()->update(['skills_json' => json_encode($this->skills)]);
            $this->skillInput = '';
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
        auth()->user()->update(['skills_json' => json_encode($this->skills)]);
    }

    public function render()
    {
        return view('livewire.formateur.profil');
    }
}
