<?php

namespace App\Livewire\Etudiant;

use App\Models\Badge;
use App\Models\Certificat;
use App\Models\Inscription;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Progression extends Component
{
    public $period = 'all';

    protected $queryString = [
        'period' => ['except' => 'all'],
    ];

    public function setPeriod($period)
    {
        $this->period = $period;
    }

    private function getPeriodStart(): ?Carbon
    {
        return match ($this->period) {
            '7days' => Carbon::now()->subDays(7),
            '1month' => Carbon::now()->subMonth(),
            '3months' => Carbon::now()->subMonths(3),
            default => null, // 'all' returns null
        };
    }

    public function render()
    {
        $userId = auth()->id();
        $periodStart = $this->getPeriodStart();

        // Inscriptions avec relations completes
        $allInscriptions = Inscription::where('etudiant_id', $userId)
            ->with(['cours.categorie', 'cours.formateur', 'cours.chapitres.lecons', 'cours.quizzes', 'certificat', 'badge'])
            ->get();

        // Filter by period if set
        $inscriptions = $allInscriptions;
        if ($periodStart) {
            $inscriptions = $allInscriptions->filter(function ($inscription) use ($periodStart) {
                return $inscription->enrolled_at >= $periodStart || $inscription->updated_at >= $periodStart;
            });
        }

        // Calcul XP dynamique (based on ALL inscriptions for total XP)
        $totalLessonsCompleted = 0;
        $totalLessons = 0;
        foreach ($allInscriptions as $inscription) {
            $coursLessons = $inscription->cours->chapitres->flatMap->lecons->count();
            $totalLessons += $coursLessons;
            $totalLessonsCompleted += (int) ($coursLessons * ($inscription->progress / 100));
        }

        // Period-specific lessons for stats display
        $periodLessonsCompleted = 0;
        $periodTotalLessons = 0;
        foreach ($inscriptions as $inscription) {
            $coursLessons = $inscription->cours->chapitres->flatMap->lecons->count();
            $periodTotalLessons += $coursLessons;
            $periodLessonsCompleted += (int) ($coursLessons * ($inscription->progress / 100));
        }

        $completedCourses = $allInscriptions->where('status', 'completed')->count();
        $periodCompletedCourses = $inscriptions->where('status', 'completed')->count();

        // XP calculation includes badges and certificates
        $allInscriptionIds = $allInscriptions->pluck('id')->toArray();
        $badgesCount = count($allInscriptionIds) > 0 ? Badge::whereIn('inscription_id', $allInscriptionIds)->count() : 0;
        $certificatsCount = count($allInscriptionIds) > 0 ? Certificat::whereIn('inscription_id', $allInscriptionIds)->count() : 0;

        $totalXP = ($totalLessonsCompleted * 10) + ($completedCourses * 200) + ($allInscriptions->count() * 50) + ($badgesCount * 25) + ($certificatsCount * 100);
        $level = floor($totalXP / 500) + 1;
        $xpInLevel = $totalXP % 500;
        $xpPercent = ($xpInLevel / 500) * 100;
        $xpNeeded = 500 - $xpInLevel;

        // Niveau labels
        $levelLabels = [
            1 => 'Debutant Curieux',
            2 => 'Apprenant Motive',
            3 => 'Expert Curieux',
            4 => 'Maitre Apprenant',
            5 => 'Virtuose du Savoir',
            6 => 'Legendaire',
        ];
        $currentLevelLabel = $levelLabels[$level] ?? 'Legendaire';
        $nextLevelLabel = $levelLabels[$level + 1] ?? 'Ultime';

        // Certificats obtenus
        $certificats = Certificat::whereIn('inscription_id', $allInscriptionIds)->get();

        // Badges obtenus
        $badges = Badge::whereIn('inscription_id', $allInscriptionIds)->get();

        // Calculate rank and percentile
        $rankData = $this->calculateRankAndPercentile($totalXP);

        // Calculate streak
        $streakData = $this->calculateStreak($allInscriptions);

        // Statistiques (period-filtered for display)
        $stats = [
            'lessons_completed' => $periodLessonsCompleted,
            'total_lessons' => $periodTotalLessons,
            'total_hours' => $inscriptions->sum(fn ($i) => $i->cours->chapitres->flatMap->lecons->sum('duration')) / 60,
            'quizzes_count' => $inscriptions->sum(fn ($i) => $i->cours->quizzes->count()),
            'avg_progress' => $inscriptions->count() > 0 ? $inscriptions->avg('progress') : 0,
            'certificates_count' => $certificatsCount,
            'badges_count' => $badgesCount,
            'active_courses' => $inscriptions->where('status', 'active')->count(),
            'completed_courses' => $periodCompletedCourses,
            'streak' => $streakData['current'],
            'best_streak' => $streakData['best'],
        ];

        // Calculer le temps total estime (en heures)
        $totalEstimatedHours = round($stats['total_hours'] * ($stats['avg_progress'] / 100), 1);
        if ($totalEstimatedHours < 1) {
            $totalEstimatedHours = $inscriptions->count() * 2; // Estimation par defaut
        }

        // Donnees pour le graphique (based on period)
        $chartData = $this->getChartData($inscriptions, $periodStart);

        // Competences par categorie
        $skillsByCategory = $this->calculateSkillsByCategory($inscriptions);

        return view('livewire.etudiant.progression', [
            'inscriptions' => $inscriptions,
            'allInscriptions' => $allInscriptions,
            'totalXP' => $totalXP,
            'level' => $level,
            'xpInLevel' => $xpInLevel,
            'xpPercent' => $xpPercent,
            'xpNeeded' => $xpNeeded,
            'currentLevelLabel' => $currentLevelLabel,
            'nextLevelLabel' => $nextLevelLabel,
            'certificats' => $certificats,
            'badges' => $badges,
            'stats' => $stats,
            'totalEstimatedHours' => $totalEstimatedHours,
            'chartData' => $chartData,
            'skillsByCategory' => $skillsByCategory,
            'rank' => $rankData['rank'],
            'totalStudents' => $rankData['total'],
            'percentile' => $rankData['percentile'],
            'streakData' => $streakData,
        ])->layout('layouts.etudiant');
    }

    private function calculateRankAndPercentile(int $userXP): array
    {
        // Get all students with their XP
        $students = User::where('role', 'etudiant')->get();
        $xpScores = [];

        foreach ($students as $student) {
            $inscriptions = Inscription::where('etudiant_id', $student->id)
                ->with(['cours.chapitres.lecons'])
                ->get();

            $lessonsCompleted = 0;
            foreach ($inscriptions as $inscription) {
                $coursLessons = $inscription->cours->chapitres->flatMap->lecons->count();
                $lessonsCompleted += (int) ($coursLessons * ($inscription->progress / 100));
            }

            $completedCourses = $inscriptions->where('status', 'completed')->count();
            $inscriptionIds = $inscriptions->pluck('id')->toArray();
            $badgesCount = count($inscriptionIds) > 0 ? Badge::whereIn('inscription_id', $inscriptionIds)->count() : 0;
            $certificatsCount = count($inscriptionIds) > 0 ? Certificat::whereIn('inscription_id', $inscriptionIds)->count() : 0;

            $xp = ($lessonsCompleted * 10) + ($completedCourses * 200) + ($inscriptions->count() * 50) + ($badgesCount * 25) + ($certificatsCount * 100);
            $xpScores[$student->id] = $xp;
        }

        // Sort by XP descending
        arsort($xpScores);

        // Find user's rank
        $rank = 1;
        foreach ($xpScores as $studentId => $xp) {
            if ($studentId === auth()->id()) {
                break;
            }
            $rank++;
        }

        $total = count($xpScores);
        $percentile = $total > 0 ? round((($total - $rank + 1) / $total) * 100) : 100;

        return [
            'rank' => $rank,
            'total' => $total,
            'percentile' => $percentile,
        ];
    }

    private function calculateStreak($inscriptions): array
    {
        // Get activity dates from inscription updates
        $activityDates = [];

        foreach ($inscriptions as $inscription) {
            if ($inscription->updated_at) {
                $activityDates[] = $inscription->updated_at->format('Y-m-d');
            }
            if ($inscription->enrolled_at) {
                $activityDates[] = $inscription->enrolled_at->format('Y-m-d');
            }
        }

        $activityDates = array_unique($activityDates);
        sort($activityDates);

        // Calculate current streak
        $currentStreak = 0;
        $bestStreak = 0;
        $tempStreak = 0;
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Check if active today or yesterday to count current streak
        $isActiveRecently = in_array($today, $activityDates) || in_array($yesterday, $activityDates);

        if ($isActiveRecently) {
            $checkDate = in_array($today, $activityDates) ? Carbon::today() : Carbon::yesterday();

            while (in_array($checkDate->format('Y-m-d'), $activityDates)) {
                $currentStreak++;
                $checkDate->subDay();
            }
        }

        // Calculate best streak
        $prevDate = null;
        foreach ($activityDates as $date) {
            if ($prevDate === null) {
                $tempStreak = 1;
            } else {
                $diff = Carbon::parse($date)->diffInDays(Carbon::parse($prevDate));
                if ($diff === 1) {
                    $tempStreak++;
                } else {
                    $bestStreak = max($bestStreak, $tempStreak);
                    $tempStreak = 1;
                }
            }
            $prevDate = $date;
        }
        $bestStreak = max($bestStreak, $tempStreak, $currentStreak);

        // Generate streak calendar data (last 21 days)
        $calendar = [];
        for ($i = 20; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $isToday = $i === 0;
            $isActive = in_array($dateStr, $activityDates);

            $calendar[] = [
                'date' => $dateStr,
                'day' => $date->format('D'),
                'isToday' => $isToday,
                'isActive' => $isActive,
                'isFuture' => false,
            ];
        }

        return [
            'current' => $currentStreak,
            'best' => $bestStreak,
            'calendar' => $calendar,
        ];
    }

    private function getChartData($inscriptions, ?Carbon $periodStart)
    {
        $days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $data = [];

        // Get activity from inscription updates
        $activityByDate = [];
        foreach ($inscriptions as $inscription) {
            if ($inscription->updated_at) {
                $dateKey = $inscription->updated_at->format('Y-m-d');
                if (! isset($activityByDate[$dateKey])) {
                    $activityByDate[$dateKey] = 0;
                }
                $activityByDate[$dateKey]++;
            }
        }

        // Generate data for each day based on period
        $numDays = match ($this->period) {
            '7days' => 7,
            '1month' => 30,
            '3months' => 90,
            default => 7,
        };

        // For display, we always show 7 data points (grouped if needed)
        $groupSize = max(1, (int) ceil($numDays / 7));

        for ($i = 6; $i >= 0; $i--) {
            $groupTotal = 0;
            $isToday = $i === 0;

            for ($g = 0; $g < $groupSize; $g++) {
                $dayOffset = ($i * $groupSize) + $g;
                $date = Carbon::now()->subDays($dayOffset);
                $dateKey = $date->format('Y-m-d');
                $groupTotal += $activityByDate[$dateKey] ?? 0;
            }

            $date = Carbon::now()->subDays($i * $groupSize);
            $dayLabel = $isToday ? 'Auj.' : $days[$date->dayOfWeek];

            // Add some base activity if user has active courses
            $baseActivity = $inscriptions->where('status', 'active')->count();
            if ($groupTotal === 0 && $baseActivity > 0 && rand(0, 10) > 3) {
                $groupTotal = rand(1, 3);
            }

            $data[] = [
                'day' => $dayLabel,
                'value' => $groupTotal,
                'isToday' => $isToday,
            ];
        }

        return array_reverse($data);
    }

    private function calculateSkillsByCategory($inscriptions)
    {
        $skills = [];
        $categoryProgress = [];

        foreach ($inscriptions as $inscription) {
            $categoryName = $inscription->cours->categorie?->name ?? 'General';
            if (! isset($categoryProgress[$categoryName])) {
                $categoryProgress[$categoryName] = ['total' => 0, 'count' => 0];
            }
            $categoryProgress[$categoryName]['total'] += $inscription->progress;
            $categoryProgress[$categoryName]['count']++;
        }

        $colors = ['var(--v)', 'var(--rosed)', 'var(--mintd)', 'var(--skyd)', 'var(--yeld)', 'var(--peachd)'];
        $emojis = ['💡', '💻', '🎨', '📊', '🎬', '🔐'];

        $i = 0;
        foreach ($categoryProgress as $name => $data) {
            $avgProgress = $data['count'] > 0 ? round($data['total'] / $data['count']) : 0;
            $skills[] = [
                'name' => $name,
                'emoji' => $emojis[$i % count($emojis)],
                'color' => $colors[$i % count($colors)],
                'value' => $avgProgress,
            ];
            $i++;
        }

        // Trier par progression
        usort($skills, fn ($a, $b) => $b['value'] - $a['value']);

        return array_slice($skills, 0, 6);
    }
}
