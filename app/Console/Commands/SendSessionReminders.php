<?php

namespace App\Console\Commands;

use App\Models\Session;
use App\Notifications\SessionReminderNotification;
use Illuminate\Console\Command;

class SendSessionReminders extends Command
{
    protected $signature = 'sessions:send-reminders';

    protected $description = 'Send automatic 30-minute reminders for upcoming sessions';

    public function handle(): int
    {
        $windowStart = now()->addMinutes(29);
        $windowEnd = now()->addMinutes(31);
        $sent = 0;

        $sessions = Session::with('cours.inscriptions.etudiant')
            ->where('auto_reminder_30m_enabled', true)
            ->whereNull('auto_reminder_30m_sent_at')
            ->whereBetween('start_time', [$windowStart, $windowEnd])
            ->get();

        foreach ($sessions as $session) {
            $excluded = collect($session->excluded_attendee_ids ?? [])->map(fn ($id) => (int) $id);

            foreach ($session->cours->inscriptions as $inscription) {
                if (! $inscription->etudiant || $excluded->contains((int) $inscription->etudiant_id)) {
                    continue;
                }

                $inscription->etudiant->notify(new SessionReminderNotification($session, '30m'));
                $sent++;
            }

            $session->update(['auto_reminder_30m_sent_at' => now()]);
        }

        $this->info("Session reminders sent: {$sent}");

        return self::SUCCESS;
    }
}
