<?php

namespace App\Livewire\Formateur;

use Illuminate\Support\Facades\Hash;
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

    public bool $student_messages = true;

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
        $this->student_messages = $prefs['student_messages'] ?? true;
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
                'student_messages' => $this->student_messages,
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

    public function updatedStudentMessages()
    {
        $this->saveNotificationPreferences();
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
