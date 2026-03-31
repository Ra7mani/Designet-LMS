<?php

namespace App\Livewire\Etudiant;

use App\Models\Badge;
use App\Models\Certificat;
use App\Models\Cours;
use App\Models\Inscription;
use App\Models\Quiz;
use App\Services\GamificationService;
use Livewire\Component;

class Dashboard extends Component
{
    public string $search = '';

    public array $searchResults = [];

    public bool $showNotifications = false;

    public array $notifications = [];

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults = Cours::where('title', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%')
                ->with('categorie', 'formateur')
                ->limit(5)
                ->get()
                ->toArray();
        } else {
            $this->searchResults = [];
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->searchResults = [];
    }

    public function toggleNotifications()
    {
        $this->showNotifications = ! $this->showNotifications;
    }

    public function markNotificationRead($index)
    {
        if (isset($this->notifications[$index])) {
            $this->notifications[$index]['read'] = true;

            if (! empty($this->notifications[$index]['id'])) {
                auth()->user()->notifications()
                    ->where('id', $this->notifications[$index]['id'])
                    ->update(['read_at' => now()]);
            }
        }
    }

    public function render()
    {
        $user = auth()->user();
        app(GamificationService::class)->syncRewardsForUser($user);

        $inscriptions = Inscription::where('etudiant_id', $user->id)
            ->with(['cours.formateur', 'cours.categorie', 'cours.chapitres.lecons', 'cours.quizzes'])
            ->get();

        $inscriptionIds = $inscriptions->pluck('id')->toArray();

        // Calculate real lessons completed
        $totalLessonsCompleted = 0;
        $totalLessons = 0;
        foreach ($inscriptions as $inscription) {
            $coursLessons = $inscription->cours->chapitres->flatMap->lecons->count();
            $totalLessons += $coursLessons;
            $totalLessonsCompleted += (int) ($coursLessons * ($inscription->progress / 100));
        }

        // Calculate XP
        $completedCourses = $inscriptions->where('status', 'completed')->count();
        $badgesCount = count($inscriptionIds) > 0 ? Badge::whereIn('inscription_id', $inscriptionIds)->count() : 0;
        $certificatsCount = count($inscriptionIds) > 0 ? Certificat::whereIn('inscription_id', $inscriptionIds)->count() : 0;

        $totalXP = ($totalLessonsCompleted * 10) + ($completedCourses * 200) + ($inscriptions->count() * 50) + ($badgesCount * 25) + ($certificatsCount * 100);
        $level = floor($totalXP / 500) + 1;
        $xpInLevel = $totalXP % 500;
        $xpPercent = ($xpInLevel / 500) * 100;
        $xpNeeded = 500 - $xpInLevel;

        $levelLabels = [
            1 => 'Debutant',
            2 => 'Apprenti',
            3 => 'Intermediaire',
            4 => 'Avance',
            5 => 'Expert',
            6 => 'Maitre',
        ];
        $currentLevelLabel = $levelLabels[$level] ?? 'Legendaire';

        $stats = [
            'cours_en_cours' => $inscriptions->where('status', 'active')->count(),
            'lecons_completees' => $totalLessonsCompleted,
            'total_lecons' => $totalLessons,
            'badges' => $badgesCount,
            'certificats' => $certificatsCount,
            'completed_courses' => $completedCourses,
        ];

        $dernierCours = $inscriptions->where('status', 'active')
            ->sortByDesc('updated_at')
            ->first();

        // Get next quiz/exam
        $prochainExamen = null;
        $activeInscriptions = $inscriptions->where('status', 'active');
        if ($activeInscriptions->count() > 0) {
            $coursIds = $activeInscriptions->pluck('cours_id');
            $prochainExamen = Quiz::whereIn('cours_id', $coursIds)
                ->with('cours')
                ->first();
        }

        $badgeNotifications = $user->notifications()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                $payload = $notification->data ?? [];

                return [
                    'id' => $notification->id,
                    'icon' => ($payload['type'] ?? '') === 'badge_unlocked' ? '🏅' : '🔔',
                    'title' => ($payload['type'] ?? '') === 'badge_unlocked'
                        ? 'Nouveau badge obtenu'
                        : 'Notification',
                    'message' => ($payload['type'] ?? '') === 'badge_unlocked'
                        ? 'Badge "'.($payload['name'] ?? 'Nouveau badge').'" debloque.'
                        : 'Nouvelle activite detectee.',
                    'time' => optional($notification->created_at)->diffForHumans(),
                    'read' => $notification->read_at !== null,
                    'type' => 'system',
                ];
            })
            ->toArray();

        // Generate notifications
        $this->notifications = $this->generateNotifications($inscriptions, $dernierCours, $stats, $badgeNotifications);
        $unreadCount = collect($this->notifications)->where('read', false)->count();

        return view('livewire.etudiant.dashboard', [
            'stats' => $stats,
            'inscriptions' => $inscriptions,
            'dernierCours' => $dernierCours,
            'totalXP' => $totalXP,
            'level' => $level,
            'xpPercent' => $xpPercent,
            'xpNeeded' => $xpNeeded,
            'currentLevelLabel' => $currentLevelLabel,
            'prochainExamen' => $prochainExamen,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.etudiant');
    }

    private function generateNotifications($inscriptions, $dernierCours, $stats, array $badgeNotifications = []): array
    {
        $notifications = $badgeNotifications;

        // Welcome notification
        if ($inscriptions->count() === 0) {
            $notifications[] = [
                'icon' => '👋',
                'title' => 'Bienvenue sur DesignLMS !',
                'message' => 'Explore le catalogue pour commencer ton apprentissage.',
                'time' => 'Maintenant',
                'read' => false,
                'type' => 'info',
            ];
        }

        // Course progress notifications
        foreach ($inscriptions->where('status', 'active')->take(2) as $insc) {
            if ($insc->progress >= 75 && $insc->progress < 100) {
                $notifications[] = [
                    'icon' => '🔥',
                    'title' => 'Presque termine !',
                    'message' => "Tu es a {$insc->progress}% de {$insc->cours->title}",
                    'time' => 'Recemment',
                    'read' => false,
                    'type' => 'progress',
                ];
            }
        }

        // Badge notification
        if ($stats['badges'] > 0) {
            $notifications[] = [
                'icon' => '🏅',
                'title' => 'Badges obtenus',
                'message' => "Tu as {$stats['badges']} badge(s) a ton actif !",
                'time' => 'Cette semaine',
                'read' => true,
                'type' => 'badge',
            ];
        }

        // Certificate notification
        if ($stats['certificats'] > 0) {
            $notifications[] = [
                'icon' => '🎓',
                'title' => 'Certificats disponibles',
                'message' => "Tu as {$stats['certificats']} certificat(s) pret(s) !",
                'time' => 'Cette semaine',
                'read' => true,
                'type' => 'certificate',
            ];
        }

        // Add general tip if few notifications
        if (count($notifications) < 3) {
            $notifications[] = [
                'icon' => '💡',
                'title' => 'Astuce du jour',
                'message' => 'Apprends 15 min par jour pour progresser rapidement !',
                'time' => "Aujourd'hui",
                'read' => true,
                'type' => 'tip',
            ];
        }

        return $notifications;
    }
}
