<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create();
        $curso = \App\Models\Cours::first() ?? \App\Models\Cours::factory()->create();

        // TODAY'S SESSION
        \App\Models\Session::create([
            'title' => 'Session Live: UX Design',
            'description' => 'Apprendre les principes du design UX moderne',
            'start_time' => now()->setHour(10)->setMinute(0)->setSecond(0),
            'end_time' => now()->setHour(12)->setMinute(0)->setSecond(0),
            'status' => 'scheduled',
            'cours_id' => $curso->id,
            'formateur_id' => $user->id,
            'virtual_room_link' => 'https://meet.google.com/abc-defg-hij',
            'max_attendees' => 30,
        ]);

        // TOMORROW MORNING (THIS WEEK)
        \App\Models\Session::create([
            'title' => 'Atelier: JavaScript Avancé',
            'description' => 'Approfondissez vos connaissances en JavaScript',
            'start_time' => now()->addDays(1)->setHour(9)->setMinute(0)->setSecond(0),
            'end_time' => now()->addDays(1)->setHour(11)->setMinute(0)->setSecond(0),
            'status' => 'scheduled',
            'cours_id' => $curso->id,
            'formateur_id' => $user->id,
            'virtual_room_link' => 'https://meet.google.com/xyz-uvwx-abc',
            'max_attendees' => 25,
        ]);

        // THIS WEEK (2 DAYS FROM NOW)
        \App\Models\Session::create([
            'title' => 'Séance Q&A: Frameworks',
            'description' => 'Posez vos questions sur les frameworks.',
            'start_time' => now()->addDays(2)->setHour(14)->setMinute(0)->setSecond(0),
            'end_time' => now()->addDays(2)->setHour(15)->setMinute(0)->setSecond(0),
            'status' => 'scheduled',
            'cours_id' => $curso->id,
            'formateur_id' => $user->id,
            'virtual_room_link' => 'https://meet.google.com/pqr-stuv-wxy',
            'max_attendees' => 50,
        ]);

        // THIS WEEK (3 DAYS FROM NOW)
        \App\Models\Session::create([
            'title' => 'Workshop: React Hooks',
            'description' => 'Maîtriser les React Hooks en profondeur',
            'start_time' => now()->addDays(3)->setHour(16)->setMinute(0)->setSecond(0),
            'end_time' => now()->addDays(3)->setHour(17)->setMinute(30)->setSecond(0),
            'status' => 'scheduled',
            'cours_id' => $curso->id,
            'formateur_id' => $user->id,
            'virtual_room_link' => 'https://meet.google.com/efg-hijk-lmn',
            'max_attendees' => 20,
        ]);

        // CREATE EVENTS FROM SESSIONS
        $sessions = \App\Models\Session::all();
        foreach ($sessions as $session) {
            \App\Models\Event::create([
                'title' => $session->title,
                'description' => $session->description,
                'start_date' => $session->start_time,
                'end_date' => $session->end_time,
                'event_type' => 'session',
                'location' => 'Salle Virtuelle',
                'session_id' => $session->id,
                'created_by' => $user->id,
            ]);
        }

        // ADD EXAMS (FOR BANNER AND STATISTICS)
        // EXAM WITHIN 48 HOURS
        \App\Models\Event::create([
            'title' => 'Examen Motion Design',
            'description' => 'Évaluation des compétences en design de mouvement',
            'start_date' => now()->addHours(36),
            'end_date' => now()->addHours(38),
            'event_type' => 'exam',
            'location' => 'Salle 101',
            'cours_id' => $curso->id,
            'created_by' => $user->id,
        ]);

        // ANOTHER EXAM (3 DAYS AWAY)
        \App\Models\Event::create([
            'title' => 'Examen JavaScript Avancé',
            'description' => 'Test de maîtrise du JavaScript moderne',
            'start_date' => now()->addDays(3)->setHour(14)->setMinute(0),
            'end_date' => now()->addDays(3)->setHour(16)->setMinute(0),
            'event_type' => 'exam',
            'location' => 'Salle 102',
            'cours_id' => $curso->id,
            'created_by' => $user->id,
        ]);

        // ADD WEBINAR/COURSE EVENTS
        \App\Models\Event::create([
            'title' => 'Webinaire: Tendances Web 2024',
            'description' => 'Découvrez les grandes tendances du web design',
            'start_date' => now()->addDays(5)->setHour(18)->setMinute(0),
            'end_date' => now()->addDays(5)->setHour(19)->setMinute(30),
            'event_type' => 'course',
            'location' => 'En ligne',
            'cours_id' => $curso->id,
            'created_by' => $user->id,
        ]);

        \App\Models\Event::create([
            'title' => 'Séminaire: UI Design Patterns',
            'description' => 'Patterns et bonnes pratiques en design UI',
            'start_date' => now()->addDays(7)->setHour(10)->setMinute(0),
            'end_date' => now()->addDays(7)->setHour(11)->setMinute(30),
            'event_type' => 'course',
            'location' => 'Amphithéâtre',
            'cours_id' => $curso->id,
            'created_by' => $user->id,
        ]);
    }
}
