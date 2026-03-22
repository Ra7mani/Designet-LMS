<?php

namespace App\Livewire\Etudiant;

use App\Models\Inscription;
use Livewire\Component;
use Carbon\Carbon;

class MesCours extends Component
{
    public string $search = '';
    public string $tab = 'tous';
    public string $sortBy = 'recent';
    public string $view = 'grid';

    protected $queryString = [
        'tab' => ['except' => 'tous'],
        'sortBy' => ['except' => 'recent'],
    ];

    public function updatedSearch()
    {
        // Livewire will automatically re-render
    }

    public function setTab(string $tab)
    {
        $this->tab = $tab;
    }

    public function setSort(string $sort)
    {
        $this->sortBy = $sort;
    }

    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function render()
    {
        $query = Inscription::where('etudiant_id', auth()->id())
            ->with(['cours.formateur', 'cours.categorie', 'cours.chapitres.lecons', 'certificat']);

        // Get all inscriptions first for stats
        $allInscriptions = $query->get();

        // Calculate stats
        $stats = $this->calculateStats($allInscriptions);

        // Apply search filter
        $inscriptions = $allInscriptions;
        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $inscriptions = $inscriptions->filter(function ($inscription) use ($searchTerm) {
                return str_contains(strtolower($inscription->cours->title), $searchTerm)
                    || str_contains(strtolower($inscription->cours->categorie?->name ?? ''), $searchTerm)
                    || str_contains(strtolower($inscription->cours->formateur?->name ?? ''), $searchTerm);
            });
        }

        // Apply tab filter
        $inscriptions = $this->applyTabFilter($inscriptions);

        // Apply sorting
        $inscriptions = $this->applySorting($inscriptions);

        // Get last active course
        $dernierCours = $allInscriptions->where('status', 'active')
            ->sortByDesc('updated_at')
            ->first();

        // Separate courses by status for display
        $coursEnCours = $inscriptions->where('status', 'active');
        $coursTermines = $inscriptions->where('status', 'completed');
        $coursNouveaux = $inscriptions->filter(function ($i) {
            return $i->enrolled_at && $i->enrolled_at->gt(Carbon::now()->subDays(7)) && $i->progress < 10;
        });

        return view('livewire.etudiant.mes-cours', [
            'inscriptions' => $inscriptions,
            'allInscriptions' => $allInscriptions,
            'stats' => $stats,
            'dernierCours' => $dernierCours,
            'coursEnCours' => $coursEnCours,
            'coursTermines' => $coursTermines,
            'coursNouveaux' => $coursNouveaux,
        ])->layout('layouts.etudiant');
    }

    private function calculateStats($inscriptions): array
    {
        $enCours = $inscriptions->where('status', 'active')->count();
        $termines = $inscriptions->where('status', 'completed')->count();

        // Calculate total chapters
        $totalChapitres = $inscriptions->sum(fn($i) => $i->cours->chapitres?->count() ?? 0);

        // Calculate total hours from lesson durations
        $totalMinutes = 0;
        foreach ($inscriptions as $inscription) {
            $totalMinutes += $inscription->cours->chapitres->flatMap->lecons->sum('duration');
        }
        $totalHours = round($totalMinutes / 60, 1);
        if ($totalHours < 1) {
            $totalHours = $inscriptions->count() * 5; // Estimation par defaut
        }

        // Calculate average progress
        $avgProgress = $inscriptions->count() > 0 ? round($inscriptions->avg('progress'), 0) : 0;

        // Calculate lessons completed
        $lessonsCompleted = 0;
        $totalLessons = 0;
        foreach ($inscriptions as $inscription) {
            $coursLessons = $inscription->cours->chapitres->flatMap->lecons->count();
            $totalLessons += $coursLessons;
            $lessonsCompleted += (int) ($coursLessons * ($inscription->progress / 100));
        }

        // Count new courses (enrolled in last 7 days)
        $nouveaux = $inscriptions->filter(function ($i) {
            return $i->enrolled_at && $i->enrolled_at->gt(Carbon::now()->subDays(7));
        })->count();

        return [
            'en_cours' => $enCours,
            'termines' => $termines,
            'chapitres' => $totalChapitres,
            'heures' => $totalHours,
            'avg_progress' => $avgProgress,
            'lessons_completed' => $lessonsCompleted,
            'total_lessons' => $totalLessons,
            'nouveaux' => $nouveaux,
            'total' => $inscriptions->count(),
        ];
    }

    private function applyTabFilter($inscriptions)
    {
        return match ($this->tab) {
            'en-cours' => $inscriptions->where('status', 'active'),
            'termine' => $inscriptions->where('status', 'completed'),
            'nouveau' => $inscriptions->filter(function ($i) {
                return $i->enrolled_at && $i->enrolled_at->gt(Carbon::now()->subDays(7)) && $i->progress < 10;
            }),
            default => $inscriptions,
        };
    }

    private function applySorting($inscriptions)
    {
        return match ($this->sortBy) {
            'recent' => $inscriptions->sortByDesc('updated_at'),
            'progress' => $inscriptions->sortByDesc('progress'),
            'name' => $inscriptions->sortBy(fn($i) => $i->cours->title),
            'enrolled' => $inscriptions->sortByDesc('enrolled_at'),
            default => $inscriptions,
        };
    }
}
