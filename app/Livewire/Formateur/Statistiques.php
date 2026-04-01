<?php

namespace App\Livewire\Formateur;

use App\Models\Avis;
use App\Models\Cours;
use App\Models\Inscription;
use App\Models\Lecon;
use App\Models\Paiement;
use App\Models\Session;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.formateur')]
class Statistiques extends Component
{
    public $period = '1m';

    public $totalRevenue = 0;

    public $monthlyRevenue = 0;

    public $quarterlyRevenue = 0;

    public $newStudents = 0;

    public $newStudentsPercent = 0;

    public $averageRating = 0;

    public $ratingTrend = 0;

    public $avgCompletion = 0;

    public $completionTrend = 0;

    public $hoursTeachedThisMonth = 0;

    public $hoursTrend = 0;

    public $reviewReplyInputs = [];

    protected $formateur;

    protected $courses;

    public function mount()
    {
        $this->formateur = auth()->user();
        $this->loadStatistics();
    }

    #[Computed]
    public function monthlyRevenueData()
    {
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->startOfYear()->addMonths($i);
            $revenue = Paiement::whereHas('inscription.cours', function ($q) {
                $q->where('formateur_id', $this->formateur->id);
            })
                ->where('status', 'completed')
                ->whereMonth('paid_at', $date->month)
                ->whereYear('paid_at', $date->year)
                ->sum('amount');
            $months[] = (int) $revenue;
        }

        return $months;
    }

    #[Computed]
    public function enrollmentsByCourseName()
    {
        $courses = Cours::where('formateur_id', $this->formateur->id)->get();
        $total = 0;
        $enrollmentsData = [];

        foreach ($courses as $course) {
            $count = $course->inscriptions()->count();
            $total += $count;
            $enrollmentsData[$course->title] = $count;
        }

        // Calculate percentages
        $result = [];
        foreach ($enrollmentsData as $name => $count) {
            $percent = $total > 0 ? round(($count / $total) * 100) : 0;
            $result[$name] = [$count, $percent];
        }

        return $result;
    }

    #[Computed]
    public function coursePerformance()
    {
        $courses = Cours::where('formateur_id', $this->formateur->id)
            ->with('inscriptions')
            ->get();

        $icons = ['💡', '🖥️', '🎨', '🔬'];
        $colors = ['var(--v)', 'var(--skyd)', 'var(--mintd)', 'var(--yeld)'];
        $performance = [];

        foreach ($courses as $index => $course) {
            $count = $course->inscriptions()->count();
            if ($count === 0) {
                continue;
            }

            $avgRating = Avis::whereHas('inscription', function ($q) use ($course) {
                $q->where('cours_id', $course->id);
            })->avg('rating') ?? 0;

            $monthlyRev = Paiement::whereHas('inscription', function ($q) use ($course) {
                $q->where('cours_id', $course->id);
            })
                ->where('status', 'completed')
                ->whereMonth('paid_at', Carbon::now()->month)
                ->sum('amount');

            $avgCompletion = Inscription::where('cours_id', $course->id)
                ->avg('progress') ?? 0;

            $performance[] = [
                'icon' => $icons[$index % 4] ?? '📚',
                'name' => $course->title,
                'students' => $count,
                'rating' => round($avgRating, 1),
                'monthlyRevenue' => (int) $monthlyRev,
                'completion' => (int) $avgCompletion,
                'color' => $colors[$index % 4] ?? 'var(--v)',
            ];
        }

        return array_slice($performance, 0, 4);
    }

    #[Computed]
    public function recentReviews()
    {
        $reviews = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })
            ->approved()
            ->latest()
            ->take(2)
            ->get();

        $gradients = [
            'linear-gradient(135deg,#DB2777,#F472B6)',
            'linear-gradient(135deg,#059669,#34D399)',
            'linear-gradient(135deg,#3B82F6,#60A5FA)',
            'linear-gradient(135deg,#F59E0B,#FBBF24)',
        ];

        $result = [];
        foreach ($reviews as $index => $review) {
            $etudiant = $review->inscription?->etudiant;
            if (! $etudiant) {
                continue;
            }

            $name = $etudiant->name ?? 'Étudiant';
            $parts = preg_split('/\s+/', trim($name)) ?: [];
            $initials = strtoupper(substr($parts[0] ?? 'E', 0, 1).substr($parts[1] ?? $parts[0] ?? 'T', 0, 1));

            $result[] = [
                'id' => $review->id,
                'initials' => $initials,
                'name' => $name,
                'rating' => $review->rating,
                'text' => '"'.$review->comment.'"',
                'response' => $review->formateur_response,
                'gradient' => $gradients[$index % 4] ?? $gradients[0],
            ];
        }

        return $result;
    }

    #[Computed]
    public function ratingsBreakdown()
    {
        $avis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })->approved()->get();

        $total = $avis->count();
        if ($total === 0) {
            return [
                ['stars' => 5, 'percent' => 72],
                ['stars' => 4, 'percent' => 20],
                ['stars' => 3, 'percent' => 6],
                ['stars' => 2, 'percent' => 2],
            ];
        }

        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $avis->where('rating', $i)->count();
            $percent = round(($count / $total) * 100);
            $breakdown[] = ['stars' => $i, 'percent' => $percent];
        }

        return array_slice($breakdown, 0, 4);
    }

    public function switchPeriod($period)
    {
        $this->period = $period;
        $this->loadStatistics();
        session()->flash('message', '📊 Données : '.$this->periodLabel());
    }

    private function loadStatistics()
    {
        $now = Carbon::now();
        [$periodStart, $periodEnd] = $this->periodRange();

        $scopedPayments = Paiement::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$periodStart, $periodEnd])
            ->get();

        $allPayments = Paiement::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })->where('status', 'completed')->get();

        $this->totalRevenue = (int) $allPayments->sum('amount');
        $this->monthlyRevenue = (int) $scopedPayments->sum('amount');
        $this->quarterlyRevenue = (int) Paiement::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()])
            ->sum('amount');

        [$previousStart, $previousEnd] = $this->previousPeriodRange();
        $previousPayments = Paiement::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$previousStart, $previousEnd])
            ->get();

        // New students in selected period
        $this->newStudents = Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        });
        $this->newStudents = $this->newStudents
            ->whereBetween('enrolled_at', [$periodStart, $periodEnd])
            ->count();

        $previousStudents = Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->whereBetween('enrolled_at', [$previousStart, $previousEnd])
            ->count();
        $this->newStudentsPercent = $previousStudents > 0
            ? round((($this->newStudents - $previousStudents) / $previousStudents) * 100)
            : $this->newStudents;

        // Average rating (selected period)
        $avis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })->approved()->whereBetween('created_at', [$periodStart, $periodEnd])->get();

        $this->averageRating = $avis->count() > 0 ? round($avis->avg('rating'), 1) : 0;

        $lastPeriodAvis = Avis::whereHas('inscription', function ($q) {
            $q->whereHas('cours', function ($qq) {
                $qq->where('formateur_id', $this->formateur->id);
            });
        })->approved()->whereBetween('created_at', [$previousStart, $previousEnd])->avg('rating') ?? 0;
        $this->ratingTrend = round($this->averageRating - $lastPeriodAvis, 2);

        // Completion and trend
        $this->avgCompletion = (int) (Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->whereBetween('updated_at', [$periodStart, $periodEnd])
            ->avg('progress') ?? 0);

        $lastCompletion = (int) (Inscription::whereHas('cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })
            ->whereBetween('updated_at', [$previousStart, $previousEnd])
            ->avg('progress') ?? 0);
        $this->completionTrend = $this->avgCompletion - $lastCompletion;

        // Hours taught and trend
        $hoursCurrent = Session::where('formateur_id', $this->formateur->id)
            ->whereBetween('start_time', [$periodStart, $periodEnd])
            ->get()
            ->sum(fn ($s) => $s->start_time->diffInMinutes($s->end_time));
        $hoursPrevious = Session::where('formateur_id', $this->formateur->id)
            ->whereBetween('start_time', [$previousStart, $previousEnd])
            ->get()
            ->sum(fn ($s) => $s->start_time->diffInMinutes($s->end_time));

        $this->hoursTeachedThisMonth = (int) floor($hoursCurrent / 60);
        $this->hoursTrend = (int) floor(($hoursCurrent - $hoursPrevious) / 60);
    }

    #[Computed]
    public function retentionStats()
    {
        $query = Inscription::whereHas('cours', fn ($q) => $q->where('formateur_id', $this->formateur->id));
        $total = $query->count();
        if ($total === 0) {
            return ['retention' => 0, 'dropout' => 0];
        }

        $retained = (clone $query)->where('progress', '>=', 50)->count();
        $dropped = (clone $query)->where(function ($q) {
            $q->where('status', 'cancelled')->orWhere('progress', '<', 30);
        })->count();

        return [
            'retention' => (int) round(($retained / $total) * 100),
            'dropout' => (int) round(($dropped / $total) * 100),
        ];
    }

    #[Computed]
    public function lessonInsights()
    {
        $lessons = Lecon::whereHas('chapitre.cours', fn ($q) => $q->where('formateur_id', $this->formateur->id))->get();
        $mostViewed = $lessons->sortByDesc('view_count')->take(5)->values()->map(fn ($l) => [
            'title' => $l->title,
            'views' => (int) $l->view_count,
        ]);
        $mostAbandoned = $lessons->sortByDesc('abandon_count')->take(5)->values()->map(fn ($l) => [
            'title' => $l->title,
            'abandons' => (int) $l->abandon_count,
        ]);

        return ['viewed' => $mostViewed, 'abandoned' => $mostAbandoned];
    }

    #[Computed]
    public function rankedCourses()
    {
        $courses = Cours::where('formateur_id', $this->formateur->id)->with('inscriptions')->get()->map(function ($course) {
            $revenue = Paiement::whereHas('inscription', fn ($q) => $q->where('cours_id', $course->id))
                ->where('status', 'completed')
                ->sum('amount');
            $rating = (float) (Avis::whereHas('inscription', fn ($q) => $q->where('cours_id', $course->id))->approved()->avg('rating') ?? 0);
            $enrollments = $course->inscriptions->count();

            return [
                'id' => $course->id,
                'title' => $course->title,
                'revenue' => (int) $revenue,
                'rating' => round($rating, 1),
                'enrollments' => $enrollments,
                'score' => ((int) $revenue / 100) + ($rating * 10) + $enrollments,
            ];
        });

        return $courses->sortByDesc('score')->values()->take(5);
    }

    public function replyToReview($reviewId)
    {
        $this->validate([
            "reviewReplyInputs.$reviewId" => 'required|string|max:1000',
        ]);

        $review = Avis::whereHas('inscription.cours', function ($q) {
            $q->where('formateur_id', $this->formateur->id);
        })->findOrFail($reviewId);

        $review->update([
            'formateur_response' => trim($this->reviewReplyInputs[$reviewId]),
            'response_by' => auth()->id(),
            'response_date' => now(),
        ]);

        $this->reviewReplyInputs[$reviewId] = '';
        session()->flash('message', '✅ Réponse enregistrée');
    }

    public function exportCsv()
    {
        $rows = [];
        $rows[] = ['Periode', $this->periodLabel()];
        $rows[] = ['Revenus totaux', $this->totalRevenue];
        $rows[] = ['Revenus periode', $this->monthlyRevenue];
        $rows[] = ['Nouveaux inscrits', $this->newStudents];
        $rows[] = ['Note moyenne', $this->averageRating];
        $rows[] = ['Completion moyenne', $this->avgCompletion];
        $rows[] = ['Retention (%)', $this->retentionStats['retention']];
        $rows[] = ['Abandon (%)', $this->retentionStats['dropout']];
        $rows[] = [];
        $rows[] = ['Cours', 'Revenus', 'Note', 'Inscriptions'];
        foreach ($this->rankedCourses as $course) {
            $rows[] = [$course['title'], $course['revenue'], $course['rating'], $course['enrollments']];
        }

        $lines = collect($rows)->map(function ($row) {
            return collect($row)->map(function ($value) {
                $escaped = str_replace('"', '""', (string) $value);
                return '"'.$escaped.'"';
            })->implode(',');
        })->implode("\n");

        $filename = 'statistiques-formateur-'.now()->format('Ymd-His').'.csv';
        $dir = storage_path('app/exports');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($dir.DIRECTORY_SEPARATOR.$filename, $lines);

        return response()->download($dir.DIRECTORY_SEPARATOR.$filename)->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $pdf = Pdf::loadView('pdf.stats-report', [
            'periodLabel' => $this->periodLabel(),
            'totalRevenue' => $this->totalRevenue,
            'periodRevenue' => $this->monthlyRevenue,
            'newStudents' => $this->newStudents,
            'averageRating' => $this->averageRating,
            'avgCompletion' => $this->avgCompletion,
            'retention' => $this->retentionStats['retention'],
            'dropout' => $this->retentionStats['dropout'],
            'courses' => $this->rankedCourses,
            'lessons' => $this->lessonInsights,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'statistiques-formateur-'.now()->format('Ymd-His').'.pdf');
    }

    private function periodRange(): array
    {
        $now = Carbon::now();
        return match ($this->period) {
            '7j' => [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay()],
            '3m' => [$now->copy()->subMonths(2)->startOfMonth(), $now->copy()->endOfMonth()],
            'all' => [Carbon::create(2000, 1, 1)->startOfDay(), $now->copy()->endOfDay()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }

    private function previousPeriodRange(): array
    {
        [$start, $end] = $this->periodRange();
        $days = $start->diffInDays($end) + 1;
        $prevEnd = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        return [$prevStart, $prevEnd];
    }

    private function periodLabel(): string
    {
        return match ($this->period) {
            '7j' => '7 jours',
            '3m' => '3 mois',
            'all' => 'Tout',
            default => '1 mois',
        };
    }

    public function render()
    {
        return view('livewire.formateur.statistiques');
    }
}
