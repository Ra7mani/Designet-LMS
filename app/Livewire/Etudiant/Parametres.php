<?php

namespace App\Livewire\Etudiant;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

#[Layout('components.layouts.etudiant')]
class Parametres extends Component
{
    // Section state
    public string $activeSection = 'account';

    // Account Section
    #[Rule('required|string|max:255')]
    public string $firstName = '';

    #[Rule('required|string|max:255')]
    public string $lastName = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('nullable|string|max:20')]
    public string $phone = '';

    #[Rule('nullable|string|max:2000')]
    public string $bio = '';

    #[Rule('required|in:fr,en,ar')]
    public string $language = 'fr';

    // Notification Section
    public bool $email_notifications = true;
    public bool $course_reminders = true;
    public bool $announcements = false;
    public bool $forum_messages = true;

    // Security Section
    #[Rule('required|string')]
    public string $currentPassword = '';

    #[Rule('required|string|min:8|confirmed')]
    public string $newPassword = '';

    public string $newPassword_confirmation = '';
    public bool $showCurrentPassword = false;
    public bool $showNewPassword = false;
    public bool $showPasswordConfirmation = false;
    public bool $twoFactorEnabled = false;
    public string $twoFactorQrCode = '';
    public array $recoveryCodesList = [];
    public string $confirmPasswordForTwoFactor = '';
    public string $twoFactorOtpInput = '';

    // Preferences Section
    #[Rule('boolean')]
    public bool $darkMode = false;

    // Subscription
    public string $subscriptionPlan = 'free';
    public ?string $subscriptionExpiresAt = null;

    // Modal states
    public bool $showDeleteModal = false;
    public bool $show2FASetupModal = false;
    public bool $showUpgradeModal = false;
    public string $deleteConfirmationText = '';
    public string $selectedPlan = 'premium';

    // Error handling
    public string $passwordChangeError = '';
    public string $passwordChangeSuccess = '';
    public string $twoFactorError = '';

    public function mount()
    {
        $user = auth()->user();

        // Load account info
        $this->firstName = $user->name ? explode(' ', $user->name)[0] : '';
        $this->lastName = $user->name ? (isset(explode(' ', $user->name)[1]) ? explode(' ', $user->name)[1] : '') : '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->bio = $user->bio ?? '';
        $this->language = $user->language ?? 'fr';

        // Load notification preferences
        $notifPrefs = $user->getNotificationPreferences();
        $this->email_notifications = $notifPrefs['email_notifications'] ?? true;
        $this->course_reminders = $notifPrefs['course_reminders'] ?? true;
        $this->announcements = $notifPrefs['announcements'] ?? false;
        $this->forum_messages = $notifPrefs['forum_messages'] ?? true;

        // Load preferences
        $this->darkMode = $user->dark_mode ?? false;

        // Load subscription
        $this->subscriptionPlan = $user->subscription_plan ?? 'free';
        $this->subscriptionExpiresAt = $user->subscription_expires_at?->format('Y-m-d');

        // Check 2FA status
        $this->twoFactorEnabled = $user->hasActiveTwoFactor();
    }

    // ==================== ACCOUNT SECTION ====================

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

    public function updateAccountInfo()
    {
        try {
            $this->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
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
            $this->dispatch('notify', message: '❌ Erreur: ' . $e->getMessage());
        }
    }

    // ==================== NOTIFICATION SECTION ====================

    public function updatedEmailNotifications()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedCourseReminders()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedAnnouncements()
    {
        $this->saveNotificationPreferences();
    }

    public function updatedForumMessages()
    {
        $this->saveNotificationPreferences();
    }

    public function saveNotificationPreferences()
    {
        try {
            $prefs = [
                'email_notifications' => $this->email_notifications,
                'course_reminders' => $this->course_reminders,
                'announcements' => $this->announcements,
                'forum_messages' => $this->forum_messages,
            ];

            auth()->user()->updateNotificationPreferences($prefs);
            $this->dispatch('notify', message: '✅ Préférences de notification mises à jour');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur: ' . $e->getMessage());
        }
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

            // Verify current password
            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->passwordChangeError = 'Le mot de passe actuel est incorrect';
                return;
            }

            // Update password
            $user->update(['password' => Hash::make($this->newPassword)]);

            // Clear fields
            $this->currentPassword = '';
            $this->newPassword = '';
            $this->newPassword_confirmation = '';

            // Show success message
            $this->passwordChangeSuccess = '✅ Mot de passe changé avec succès';

            // Clear after 5 seconds
            $this->dispatch('clearSuccessMessage');
        } catch (\Exception $e) {
            $this->passwordChangeError = 'Erreur lors du changement de mot de passe: ' . $e->getMessage();
        }
    }

    public function toggleCurrentPassword()
    {
        $this->showCurrentPassword = !$this->showCurrentPassword;
    }

    public function toggleNewPassword()
    {
        $this->showNewPassword = !$this->showNewPassword;
    }

    public function togglePasswordConfirmation()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    public function initiateTwoFactorSetup()
    {
        try {
            $user = auth()->user();
            $provider = app(TwoFactorAuthenticationProvider::class);

            // Generate secret key
            $secret = $provider->generateSecretKey();

            // Store encrypted secret temporarily
            $user->update(['two_factor_secret' => encrypt($secret)]);

            // Generate QR code URL
            $qrCodeUrl = $provider->qrCodeUrl(config('app.name'), $user->email, $secret);

            // Create QR code SVG using BaconQrCode
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                new \BaconQrCode\Renderer\Image\SvgImageBackend()
            );
            $writer = new \BaconQrCode\Writer($renderer);
            $qrCodeData = $writer->writeString($qrCodeUrl);

            $this->twoFactorQrCode = $qrCodeData;
            $this->show2FASetupModal = true;
            $this->twoFactorError = '';
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la configuration 2FA: ' . $e->getMessage());
        }
    }

    public function confirmTwoFactorSetup()
    {
        $this->twoFactorError = '';

        try {
            $user = auth()->user();
            $provider = app(TwoFactorAuthenticationProvider::class);

            if (empty($this->twoFactorOtpInput)) {
                $this->twoFactorError = 'Veuillez entrer le code OTP';
                return;
            }

            // Verify OTP
            $secret = decrypt($user->two_factor_secret);
            $isValid = $provider->verify(
                decrypt($user->two_factor_secret),
                $this->twoFactorOtpInput
            );

            if (!$isValid) {
                $this->twoFactorError = 'Code OTP invalide';
                return;
            }

            // Generate recovery codes
            $codes = $provider->generateRecoveryCodes();

            // Update user with recovery codes and confirmation timestamp
            $user->update([
                'two_factor_confirmed_at' => now(),
                'two_factor_recovery_codes' => json_encode($codes),
            ]);

            $this->recoveryCodesList = $codes;
            $this->twoFactorEnabled = true;
            $this->show2FASetupModal = false;
            $this->twoFactorOtpInput = '';
            $this->dispatch('notify', message: '✅ Authentification 2FA activée');
        } catch (\Exception $e) {
            $this->twoFactorError = 'Erreur: ' . $e->getMessage();
        }
    }

    public function disableTwoFactor()
    {
        try {
            auth()->user()->update([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]);

            $this->twoFactorEnabled = false;
            $this->recoveryCodesList = [];
            $this->dispatch('notify', message: '✅ Authentification 2FA désactivée');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la désactivation 2FA');
        }
    }

    public function regenerateRecoveryCodes()
    {
        try {
            $user = auth()->user();
            $provider = app(TwoFactorAuthenticationProvider::class);

            $codes = $provider->generateRecoveryCodes();
            $user->update(['two_factor_recovery_codes' => json_encode($codes)]);

            $this->recoveryCodesList = $codes;
            $this->dispatch('notify', message: '✅ Codes de récupération régénérés');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la régénération');
        }
    }

    // ==================== DATA MANAGEMENT ====================

    public function requestDataExport()
    {
        try {
            $user = auth()->user();

            $data = [
                'export_date' => now()->toIso8601String(),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'bio' => $user->bio,
                    'location' => $user->location,
                    'professional_objective' => $user->professional_objective,
                    'skills' => $user->getSkills(),
                    'created_at' => $user->created_at->toIso8601String(),
                ],
                'courses' => $user->inscriptions()
                    ->with('cours')
                    ->get()
                    ->map(fn($insc) => [
                        'course_name' => $insc->cours->nom,
                        'enrolled_at' => $insc->created_at->toIso8601String(),
                    ]),
                'social_links' => [
                    'linkedin' => $user->linkedin_url,
                    'github' => $user->github_url,
                    'portfolio' => $user->portfolio_url,
                ],
            ];

            $filename = "export_" . $user->id . "_" . now()->format('Y-m-d_H-i-s') . ".json";
            $filepath = "exports/{$filename}";

            Storage::disk('public')->put($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return Storage::disk('public')->download($filepath, $filename);
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de l\'export');
        }
    }

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

            // Soft delete user
            auth()->user()->delete();

            // Log out
            auth()->logout();

            return redirect('/login');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la suppression');
        }
    }

    // ==================== SUBSCRIPTION MANAGEMENT ====================

    public function openUpgradeModal()
    {
        $this->showUpgradeModal = true;
        $this->selectedPlan = 'premium';
    }

    public function upgradePlan()
    {
        try {
            $user = auth()->user();

            // Simple upgrade logic - in production, integrate with payment gateway
            $subscription_expires_at = match($this->selectedPlan) {
                'premium' => now()->addDays(30),
                'pro' => now()->addDays(90),
                'enterprise' => now()->addDays(365),
                default => now()->addDays(30),
            };

            $user->update([
                'subscription_plan' => $this->selectedPlan,
                'subscription_expires_at' => $subscription_expires_at,
            ]);

            // Reload data
            $this->subscriptionPlan = $user->subscription_plan;
            $this->subscriptionExpiresAt = $user->subscription_expires_at?->format('Y-m-d');

            $this->showUpgradeModal = false;
            $this->dispatch('notify', message: '✅ Plan mis à jour avec succès!');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la mise à jour du plan: ' . $e->getMessage());
        }
    }

    // ==================== BULK SAVE ALL ====================

    public function saveAll()
    {
        try {
            // Save account info
            $this->updateAccountInfo();

            // Save notification preferences
            $this->saveNotificationPreferences();

            $this->dispatch('notify', message: '✅ Tous les paramètres ont été sauvegardés!');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: '❌ Erreur lors de la sauvegarde: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.etudiant.parametres');
    }
}
