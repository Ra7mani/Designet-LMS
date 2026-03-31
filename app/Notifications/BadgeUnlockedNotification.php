<?php

namespace App\Notifications;

use App\Models\Badge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BadgeUnlockedNotification extends Notification
{
    use Queueable;

    public function __construct(public Badge $badge) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau badge obtenu')
            ->greeting('Bravo '.$notifiable->name.' !')
            ->line('Tu viens de debloquer le badge "'.$this->badge->name.'".')
            ->line($this->badge->description ?: 'Continue ton apprentissage pour en gagner d\'autres.')
            ->action('Voir mes badges', route('etudiant.badges'))
            ->line('Tu progresses tres bien, continue comme ca.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'badge_unlocked',
            'badge_id' => $this->badge->id,
            'name' => $this->badge->name,
            'description' => $this->badge->description,
            'earned_at' => optional($this->badge->earned_at)->toIso8601String(),
        ];
    }
}
