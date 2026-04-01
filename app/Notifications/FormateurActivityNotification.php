<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FormateurActivityNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $message,
        public ?string $url = null,
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        $prefs = method_exists($notifiable, 'getNotificationPreferences') ? $notifiable->getNotificationPreferences() : [];

        if (($prefs['email_notifications'] ?? true) === true) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->title)
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line($this->message);

        if ($this->url) {
            $mail->action('Voir le détail', $this->url);
        }

        return $mail->line('Merci d\'utiliser DesignLMS.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}
