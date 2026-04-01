<?php

namespace App\Livewire\Formateur;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.formateur')]
class Parametres extends Component
{
    public string $activeSection = 'account';

    // Account
    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $phone = '';

    public string $bio = '';

    public string $language = 'fr';

    // Notifications
    public bool $email_notifications = true;

    public bool $course_reminders = true;

    public bool $forum_messages = true;

    // Preferences
    public bool $darkMode = false;

    public string $accentColor = 'purple';

    // Subscription
    public string $subscriptionPlan = 'free';

    public ?string $subscriptionExpiresAt = null;

    public bool $showUpgradeModal = false;

    public string $selectedPlan = 'pro';

    // Security
    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPassword_confirmation = '';

    public bool $showCurrentPassword = false;

    public bool $showNewPassword = false;

    public bool $showPasswordConfirmation = false;

    public string $passwordChangeError = '';

    public string $passwordChangeSuccess = '';

    // Modal
    public bool $showDeleteModal = false;

    public string $deleteConfirmationText = '';

    public function mount()
    {
        $user = auth()->user();

        $this->firstName = $user->name ? explode(' ', $user->name)[0] : '';
        $this->lastName = $user->name ? (isset(explode(' ', $user->name)[1]) ? explode(' ', $user->name)[1] : '') : '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->bio = $user->bio ?? '';
        $this->language = $user->language ?? 'fr';

        // Notifications
        $prefs = $user->getNotificationPreferences();
        $this->email_notifications = $prefs['email_notifications'] ?? true;
        $this->course_reminders = $prefs['course_reminders'] ?? true;
        $this->forum_messages = $prefs['forum_messages'] ?? true;
        $this->darkMode = (bool) ($user->dark_mode ?? false);
        $this->accentColor = (string) ($user->accent_color ?? 'purple');
        $this->subscriptionPlan = (string) ($user->subscription_plan ?? 'free');
        $this->subscriptionExpiresAt = $user->subscription_expires_at?->format('Y-m-d');
    }

    // ==================== ACCOUNT SECTION ====================

    public function updateAccountInfo()
    {
        try {
            $this->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.auth()->id(),
                'phone' => 'nullable|string|max:20',
                'bio' => 'nullable|string|max:2000',
                'language' => 'required|in:fr,en,ar',
            ]);

            $fullName = trim("{$this->firstName} {$this->lastName}");

            auth()->user()->update([
                'name' => $fullName,
                'email' => $this->email,
                'phone' => $this->phone,
                'bio' => $this->bio,
                'language' => $this->language,
            ]);

            $this->dispatch('notify', message: '✅ Informations mises à jour');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur: '.$e->getMessage());
        }
    }

    public function updatedFirstName()
    {
        $this->updateAccountInfo();
    }

    public function updatedLastName()
    {
        $this->updateAccountInfo();
    }

    public function updatedEmail()
    {
        $this->updateAccountInfo();
    }

    public function updatedPhone()
    {
        $this->updateAccountInfo();
    }

    public function updatedBio()
    {
        $this->updateAccountInfo();
    }

    public function updatedLanguage()
    {
        $this->updateAccountInfo();
    }

    // ==================== NOTIFICATION SECTION ====================

    public function saveNotificationPreferences()
    {
        try {
            $prefs = [
                'email_notifications' => $this->email_notifications,
                'course_reminders' => $this->course_reminders,
                'forum_messages' => $this->forum_messages,
            ];

            auth()->user()->updateNotificationPreferences($prefs);
            $this->dispatch('notify', message: '✅ Préférences mises à jour');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur: '.$e->getMessage());
        }
    }

    public function updatedEmailNotifications()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedCourseReminders()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedForumMessages()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedDarkMode()
    {
        auth()->user()->update(['dark_mode' => $this->darkMode]);
    }

    public function updatedAccentColor()
    {
        $this->validate(['accentColor' => 'required|in:purple,blue,green,rose,amber']);
        auth()->user()->update(['accent_color' => $this->accentColor]);
    }

    // ==================== SECURITY SECTION ====================

    public function changePassword()
    {
        $this->passwordChangeError = '';
        $this->passwordChangeSuccess = '';

        try {
            $this->validate([
                'currentPassword' => 'required|string',
                'newPassword' => 'required|string|min:8|confirmed',
            ]);

            $user = auth()->user();

            if (! Hash::check($this->currentPassword, $user->password)) {
                $this->passwordChangeError = 'Le mot de passe actuel est incorrect';

                return;
            }

            $user->update(['password' => Hash::make($this->newPassword)]);

            $this->currentPassword = '';
            $this->newPassword = '';
            $this->newPassword_confirmation = '';

            $this->passwordChangeSuccess = '✅ Mot de passe changé avec succès';
        } catch (\Exception $e) {
            $this->passwordChangeError = 'Erreur: '.$e->getMessage();
        }
    }

    public function toggleCurrentPassword()
    {
        $this->showCurrentPassword = ! $this->showCurrentPassword;
    }

    public function toggleNewPassword()
    {
        $this->showNewPassword = ! $this->showNewPassword;
    }

    public function togglePasswordConfirmation()
    {
        $this->showPasswordConfirmation = ! $this->showPasswordConfirmation;
    }

    // ==================== ACCOUNT DELETION ====================

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
        $this->deleteConfirmationText = '';
    }

    public function openUpgradeModal()
    {
        $this->showUpgradeModal = true;
        $this->selectedPlan = 'pro';
    }

    public function upgradePlan()
    {
        $this->validate(['selectedPlan' => 'required|in:pro,premium']);

        $expiresAt = $this->selectedPlan === 'premium'
            ? now()->addDays(90)
            : now()->addDays(30);

        auth()->user()->update([
            'subscription_plan' => $this->selectedPlan,
            'subscription_expires_at' => $expiresAt,
        ]);

        $this->subscriptionPlan = $this->selectedPlan;
        $this->subscriptionExpiresAt = $expiresAt->format('Y-m-d');
        $this->showUpgradeModal = false;
        $this->dispatch('notify', message: '✅ Plan mis à jour');
    }

    public function requestDataExport()
    {
        $user = auth()->user();

        $data = [
            'export_date' => now()->toIso8601String(),
            'profile' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'bio' => $user->bio,
                'location' => $user->location,
                'professional_objective' => $user->professional_objective,
                'social_links' => [
                    'linkedin' => $user->linkedin_url,
                    'github' => $user->github_url,
                    'portfolio' => $user->portfolio_url,
                ],
            ],
            'courses' => $user->cours()->withCount('inscriptions')->get()->map(fn ($course) => [
                'id' => $course->id,
                'title' => $course->title ?? $course->nom,
                'status' => (string) $course->status,
                'price' => $course->price,
                'students_count' => $course->inscriptions_count,
            ])->values()->all(),
        ];

        $filename = 'formateur-export-'.$user->id.'-'.now()->format('Ymd-His').'.json';
        $filepath = 'exports/'.$filename;
        Storage::disk('public')->put($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return Storage::disk('public')->download($filepath, $filename);
    }

    public function deleteAccount()
    {
        try {
            if ($this->deleteConfirmationText !== auth()->user()->email) {
                $this->dispatch('notify', message: '❌ Email de confirmation incorrect');

                return;
            }

            auth()->user()->delete();
            auth()->logout();

            return redirect('/login');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la suppression');
        }
    }

    public function render()
    {
        return view('livewire.formateur.parametres');
    }
}
