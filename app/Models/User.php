<?php

namespace App\Models;

use App\Enums\RoleType;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'phone',
        'location',
        'professional_objective',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'avatar_path',
        'skills_json',
        'dark_mode',
        'accent_color',
        'text_size',
        'timezone',
        'currency',
        'language',
        'notification_settings_json',
        'subscription_plan',
        'subscription_expires_at',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'password'               => 'hashed',
            'two_factor_confirmed_at'=> 'datetime',
            'role'                   => RoleType::class,
            'skills_json'            => 'array',
            'notification_settings_json' => 'array',
            'dark_mode'              => 'boolean',
            'subscription_expires_at' => 'datetime',
        ];
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'formateur_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'etudiant_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleType::Admin;
    }

    public function isFormateur(): bool
    {
        return $this->role === RoleType::Formateur;
    }

    public function isEtudiant(): bool
    {
        return $this->role === RoleType::Etudiant;
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function avatarUrl(): string
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }
        return '';
    }

    public function getSkills(): array
    {
        return $this->skills_json ?? [];
    }

    public function addSkill(string $skill): void
    {
        $skills = $this->getSkills();
        if (!in_array($skill, $skills) && count($skills) < 12) {
            $skills[] = $skill;
            $this->update(['skills_json' => $skills]);
        }
    }

    public function removeSkill(string $skill): void
    {
        $skills = $this->getSkills();
        $skills = array_filter($skills, fn($s) => $s !== $skill);
        $this->update(['skills_json' => array_values($skills)]);
    }

    public function hasCompletedProfile(): bool
    {
        return !empty($this->bio)
            || !empty($this->location)
            || !empty($this->professional_objective)
            || !empty($this->linkedin_url)
            || !empty($this->github_url)
            || !empty($this->portfolio_url)
            || !empty($this->avatar_path);
    }

    public function profileCompleteness(): int
    {
        $fields = [
            'name' => !empty($this->name),
            'email' => !empty($this->email),
            'bio' => !empty($this->bio),
            'phone' => !empty($this->phone),
            'location' => !empty($this->location),
            'professional_objective' => !empty($this->professional_objective),
            'avatar' => !empty($this->avatar_path),
            'socials' => !empty($this->linkedin_url) || !empty($this->github_url) || !empty($this->portfolio_url),
        ];
        return (int)((array_sum($fields) / count($fields)) * 100);
    }

    public function getNotificationPreferences(): array
    {
        return $this->notification_settings_json ?? [
            'email_notifications' => true,
            'course_reminders' => true,
            'announcements' => false,
            'forum_messages' => true,
        ];
    }

    public function updateNotificationPreferences(array $prefs): void
    {
        $allowedKeys = ['email_notifications', 'course_reminders', 'announcements', 'forum_messages'];
        $filtered = array_filter($prefs, fn($k) => in_array($k, $allowedKeys), ARRAY_FILTER_USE_KEY);
        $this->update(['notification_settings_json' => $filtered]);
    }

    public function hasActiveTwoFactor(): bool
    {
        return $this->two_factor_confirmed_at !== null;
    }

    public function getPreferencesSetting(string $key): mixed
    {
        $preferences = [
            'dark_mode' => $this->dark_mode,
            'accent_color' => $this->accent_color,
            'text_size' => $this->text_size,
            'timezone' => $this->timezone,
            'currency' => $this->currency,
            'language' => $this->language,
        ];
        return $preferences[$key] ?? null;
    }

    public function updatePreferencesSetting(string $key, $value): void
    {
        $allowed = ['dark_mode', 'accent_color', 'text_size', 'timezone', 'currency', 'language'];
        if (in_array($key, $allowed)) {
            $this->update([$key => $value]);
        }
    }
}