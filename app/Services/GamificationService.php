<?php

namespace App\Services;

use App\Enums\EnrollStatus;
use App\Mail\CertificateIssuedMail;
use App\Models\Badge;
use App\Models\Certificat;
use App\Models\Inscription;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Notifications\BadgeUnlockedNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GamificationService
{
    public function syncRewardsForUser(User $user): array
    {
        $newCertificates = $this->ensureCertificatesForCompletedCourses($user);
        $newBadges = $this->ensureBadges($user);

        return [
            'new_certificates' => $newCertificates,
            'new_badges' => $newBadges,
        ];
    }

    public function getDashboardMetrics(User $user): array
    {
        $inscriptions = Inscription::where('etudiant_id', $user->id)
            ->with(['cours.chapitres.lecons', 'cours.quizzes', 'cours.formateur', 'certificat'])
            ->get();

        $xpData = $this->calculateXpData($user, $inscriptions);

        $level = (int) floor($xpData['total_xp'] / 500) + 1;
        $xpInLevel = $xpData['total_xp'] % 500;
        $xpPercent = (int) min(100, round(($xpInLevel / 500) * 100));

        $ranking = $this->getRankForUser($user->id);

        return [
            'inscriptions' => $inscriptions,
            'completed_courses' => $xpData['completed_courses'],
            'active_courses' => $xpData['active_courses'],
            'total_lessons' => $xpData['total_lessons'],
            'lessons_completed' => $xpData['lessons_completed'],
            'badges_count' => $xpData['badges_count'],
            'certificates_count' => $xpData['certificates_count'],
            'quiz_passed' => $xpData['quiz_passed'],
            'has_perfect_quiz' => $xpData['has_perfect_quiz'],
            'total_xp' => $xpData['total_xp'],
            'level' => $level,
            'xp_percent' => $xpPercent,
            'xp_in_level' => $xpInLevel,
            'xp_needed' => 500 - $xpInLevel,
            'rank' => $ranking['rank'],
            'total_students' => $ranking['total_students'],
            'top_percent' => $ranking['top_percent'],
        ];
    }

    public function getLeaderboard(int $limit = 20): Collection
    {
        $students = User::where('role', 'etudiant')->get();

        $scores = $students->map(function (User $student) {
            $metrics = $this->calculateXpData($student);
            return [
                'user' => $student,
                'xp' => $metrics['total_xp'],
                'badges' => $metrics['badges_count'],
                'certificates' => $metrics['certificates_count'],
                'completed_courses' => $metrics['completed_courses'],
            ];
        })->sortByDesc('xp')->values();

        return $scores->take($limit)->map(function (array $entry, int $index) {
            $entry['rank'] = $index + 1;
            return $entry;
        });
    }

    public function getBadgeProgress(User $user): array
    {
        $metrics = $this->getDashboardMetrics($user);

        $inscriptionIds = $metrics['inscriptions']->pluck('id');
        $earnedBadges = $inscriptionIds->isEmpty()
            ? collect()
            : Badge::whereIn('inscription_id', $inscriptionIds)->orderByDesc('earned_at')->get();

        $earnedNames = $earnedBadges->pluck('name')->all();

        $allDefinitions = $this->badgeDefinitions();

        $locked = collect($allDefinitions)
            ->reject(fn (array $def) => in_array($def['name'], $earnedNames, true))
            ->map(function (array $def) use ($metrics) {
                $progress = $this->computeBadgeProgress($def['slug'], $metrics);
                return [
                    'slug' => $def['slug'],
                    'name' => $def['name'],
                    'description' => $def['description'],
                    'condition' => $def['condition'],
                    'icon' => $def['icon'],
                    'progress_value' => $progress['value'],
                    'progress_target' => $progress['target'],
                    'progress_percent' => $progress['percent'],
                ];
            })
            ->sortByDesc('progress_percent')
            ->values();

        return [
            'earned' => $earnedBadges,
            'locked' => $locked,
        ];
    }

    private function ensureCertificatesForCompletedCourses(User $user): Collection
    {
        $inscriptions = Inscription::where('etudiant_id', $user->id)
            ->with(['cours', 'etudiant', 'certificat'])
            ->get();

        $newCertificates = collect();

        foreach ($inscriptions as $inscription) {
            $isCompleted = (float) $inscription->progress >= 100
                || $inscription->status === EnrollStatus::Completed
                || $inscription->status === 'completed';

            if (!$isCompleted || $inscription->certificat) {
                continue;
            }

            if ((float) $inscription->progress >= 100 && $inscription->status !== EnrollStatus::Completed) {
                $inscription->update([
                    'status' => EnrollStatus::Completed,
                    'completed_at' => $inscription->completed_at ?: now(),
                ]);
            }

            if (Certificat::where('inscription_id', $inscription->id)->exists()) {
                continue;
            }

            $certificat = Certificat::create([
                'inscription_id' => $inscription->id,
                'issued_at' => now(),
                'certificate_number' => $this->generateCertificateNumber($inscription),
            ]);

            $pdfPath = $this->buildCertificatePdf($certificat->fresh(['inscription.cours', 'inscription.etudiant']));

            $certificat->update([
                'pdf_url' => '/storage/'.$pdfPath,
            ]);

            $certificat->load(['inscription.cours', 'inscription.etudiant']);

            if (!empty($user->email)) {
                Mail::to($user->email)->send(new CertificateIssuedMail($certificat));
            }

            $newCertificates->push($certificat);
        }

        return $newCertificates;
    }

    private function ensureBadges(User $user): Collection
    {
        $metrics = $this->getDashboardMetrics($user);
        $inscriptionIds = $metrics['inscriptions']->pluck('id');

        if ($inscriptionIds->isEmpty()) {
            return collect();
        }

        $existingNames = Badge::whereIn('inscription_id', $inscriptionIds)->pluck('name')->all();
        $created = collect();

        foreach ($this->badgeDefinitions() as $definition) {
            if (in_array($definition['name'], $existingNames, true)) {
                continue;
            }

            $progress = $this->computeBadgeProgress($definition['slug'], $metrics);
            if ($progress['value'] < $progress['target']) {
                continue;
            }

            $inscriptionId = $this->resolveBadgeInscriptionId($metrics['inscriptions']);
            if (!$inscriptionId) {
                continue;
            }

            $badge = Badge::create([
                'inscription_id' => $inscriptionId,
                'name' => $definition['name'],
                'description' => $definition['description'],
                'image_url' => null,
                'earned_at' => now(),
            ]);

            $user->notify(new BadgeUnlockedNotification($badge));
            $created->push($badge);
        }

        return $created;
    }

    private function generateCertificateNumber(Inscription $inscription): string
    {
        return sprintf(
            'CERT-%s-%d-%s',
            now()->format('Y'),
            $inscription->id,
            Str::upper(Str::random(4))
        );
    }

    private function buildCertificatePdf(Certificat $certificat): string
    {
        $courseTitle = $certificat->inscription->cours->title ?? 'Cours';
        $studentName = $certificat->inscription->etudiant->name ?? 'Etudiant';
        $issuedDate = optional($certificat->issued_at)->format('d/m/Y') ?? now()->format('d/m/Y');

        $pdf = Pdf::loadView('pdf.certificate', [
            'certificat' => $certificat,
            'courseTitle' => $courseTitle,
            'studentName' => $studentName,
            'issuedDate' => $issuedDate,
        ]);

        $path = 'certificates/certificate-'.$certificat->id.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    private function getRankForUser(int $userId): array
    {
        $students = User::where('role', 'etudiant')->get();

        $leaderboard = $students->map(function (User $student) {
            return [
                'user' => $student,
                'xp' => $this->calculateXpData($student)['total_xp'],
            ];
        })->sortByDesc('xp')->values()->map(function (array $entry, int $index) {
            $entry['rank'] = $index + 1;
            return $entry;
        });

        $totalStudents = $leaderboard->count();

        $rankEntry = $leaderboard->first(fn (array $entry) => (int) $entry['user']->id === $userId);
        $rank = $rankEntry['rank'] ?? 1;

        $topPercent = $totalStudents > 0
            ? (int) max(1, round(($rank / $totalStudents) * 100))
            : 1;

        return [
            'rank' => $rank,
            'total_students' => max(1, $totalStudents),
            'top_percent' => $topPercent,
        ];
    }

    private function calculateXpData(User $user, ?Collection $inscriptions = null): array
    {
        $inscriptions = $inscriptions ?: Inscription::where('etudiant_id', $user->id)
            ->with(['cours.chapitres.lecons'])
            ->get();

        $inscriptionIds = $inscriptions->pluck('id');

        $completedCourses = $inscriptions->filter(fn (Inscription $i) => $i->status === EnrollStatus::Completed || $i->status === 'completed')->count();
        $activeCourses = $inscriptions->filter(fn (Inscription $i) => $i->status === EnrollStatus::Active || $i->status === 'active')->count();

        $totalLessons = $inscriptions->sum(fn (Inscription $i) => $i->cours->chapitres->flatMap->lecons->count());
        $lessonsCompleted = $inscriptions->sum(function (Inscription $inscription) {
            $lessons = $inscription->cours->chapitres->flatMap->lecons->count();
            return (int) round($lessons * ((float) $inscription->progress / 100));
        });

        $badgesCount = $inscriptionIds->isEmpty() ? 0 : Badge::whereIn('inscription_id', $inscriptionIds)->count();
        $certificatesCount = $inscriptionIds->isEmpty() ? 0 : Certificat::whereIn('inscription_id', $inscriptionIds)->count();

        $quizAttempts = QuizAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->get();

        $quizPassed = $quizAttempts->where('passed', true)->count();
        $perfectQuiz = $quizAttempts->first(function (QuizAttempt $attempt) {
            return $attempt->total_points > 0 && ((int) round(($attempt->score / $attempt->total_points) * 100) === 100);
        }) !== null;

        $totalXP = ($lessonsCompleted * 10)
            + ($completedCourses * 250)
            + ($badgesCount * 120)
            + ($certificatesCount * 220)
            + ($quizPassed * 40)
            + $quizAttempts->sum('xp_earned');

        return [
            'completed_courses' => $completedCourses,
            'active_courses' => $activeCourses,
            'total_lessons' => $totalLessons,
            'lessons_completed' => $lessonsCompleted,
            'badges_count' => $badgesCount,
            'certificates_count' => $certificatesCount,
            'quiz_passed' => $quizPassed,
            'has_perfect_quiz' => $perfectQuiz,
            'total_xp' => $totalXP,
        ];
    }

    private function resolveBadgeInscriptionId(Collection $inscriptions): ?int
    {
        $completed = $inscriptions->first(fn (Inscription $i) => $i->status === EnrollStatus::Completed || $i->status === 'completed');
        if ($completed) {
            return $completed->id;
        }

        return $inscriptions->first()?->id;
    }

    private function badgeDefinitions(): array
    {
        return [
            [
                'slug' => 'first_completed_course',
                'name' => 'Premier cours termine',
                'description' => 'Tu as termine ton tout premier cours.',
                'condition' => 'Terminer 1 cours',
                'icon' => 'star',
            ],
            [
                'slug' => 'three_completed_courses',
                'name' => 'Apprenant confirme',
                'description' => 'Tu as termine 3 cours.',
                'condition' => 'Terminer 3 cours',
                'icon' => 'rocket',
            ],
            [
                'slug' => 'first_certificate',
                'name' => 'Premier certificat',
                'description' => 'Tu as obtenu ton premier certificat officiel.',
                'condition' => 'Obtenir 1 certificat',
                'icon' => 'certificate',
            ],
            [
                'slug' => 'three_certificates',
                'name' => 'Multi-certifie',
                'description' => 'Tu as obtenu 3 certificats.',
                'condition' => 'Obtenir 3 certificats',
                'icon' => 'medal',
            ],
            [
                'slug' => 'perfect_quiz',
                'name' => 'Quiz Master',
                'description' => 'Tu as reussi un quiz avec 100% de score.',
                'condition' => 'Obtenir 100% a un quiz',
                'icon' => 'bolt',
            ],
            [
                'slug' => 'xp_1000',
                'name' => 'Cap des 1000 XP',
                'description' => 'Tu as depasse les 1000 XP.',
                'condition' => 'Atteindre 1000 XP',
                'icon' => 'zap',
            ],
            [
                'slug' => 'top_10',
                'name' => 'Top 10%',
                'description' => 'Tu fais partie du top 10% du classement global.',
                'condition' => 'Atteindre le top 10%',
                'icon' => 'trophy',
            ],
        ];
    }

    private function computeBadgeProgress(string $slug, array $metrics): array
    {
        return match ($slug) {
            'first_completed_course' => $this->formatProgress($metrics['completed_courses'], 1),
            'three_completed_courses' => $this->formatProgress($metrics['completed_courses'], 3),
            'first_certificate' => $this->formatProgress($metrics['certificates_count'], 1),
            'three_certificates' => $this->formatProgress($metrics['certificates_count'], 3),
            'perfect_quiz' => $this->formatProgress($metrics['has_perfect_quiz'] ? 1 : 0, 1),
            'xp_1000' => $this->formatProgress($metrics['total_xp'], 1000),
            'top_10' => $this->formatProgress($metrics['top_percent'] <= 10 ? 1 : 0, 1),
            default => $this->formatProgress(0, 1),
        };
    }

    private function formatProgress(int $value, int $target): array
    {
        $capped = min($value, $target);
        $percent = $target > 0 ? (int) min(100, round(($capped / $target) * 100)) : 0;

        return [
            'value' => $value,
            'target' => $target,
            'percent' => $percent,
        ];
    }
}
