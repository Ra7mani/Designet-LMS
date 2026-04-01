<?php

namespace App\Notifications;

use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Session $session, public string $timing = '30m') {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $timingText = $this->timing === '30m' ? 'dans 30 minutes' : 'bientôt';

        return (new MailMessage)
            ->subject('Rappel session: '.$this->session->title)
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("La session \"{$this->session->title}\" commence {$timingText}.")
            ->line('Date: '.$this->session->start_time->format('d/m/Y H:i'))
            ->line('Salle: '.($this->session->session_room ?? 'Virtuelle'))
            ->when(
                (bool) $this->session->virtual_room_link,
                fn (MailMessage $mail) => $mail->action('Lancer la salle virtuelle', $this->session->virtual_room_link)
            )
            ->line('Merci de votre ponctualité.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'session_reminder',
            'session_id' => $this->session->id,
            'title' => $this->session->title,
            'timing' => $this->timing,
            'starts_at' => $this->session->start_time->toIso8601String(),
            'virtual_room_link' => $this->session->virtual_room_link,
        ];
    }
}
