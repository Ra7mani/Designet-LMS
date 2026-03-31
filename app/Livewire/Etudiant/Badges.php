<?php

namespace App\Livewire\Etudiant;

use App\Models\Certificat;
use App\Services\GamificationService;
use Livewire\Component;

class Badges extends Component
{
    public function mount(GamificationService $gamificationService): void
    {
        $gamificationService->syncRewardsForUser(auth()->user());
    }

    public function render()
    {
        $user = auth()->user();
        $gamificationService = app(GamificationService::class);

        $metrics = $gamificationService->getDashboardMetrics($user);
        $badgeData = $gamificationService->getBadgeProgress($user);
        $leaderboard = $gamificationService->getLeaderboard();

        $inscriptionIds = $metrics['inscriptions']->pluck('id');
        $certificats = $inscriptionIds->isEmpty()
            ? collect()
            : Certificat::whereIn('inscription_id', $inscriptionIds)
                ->with('inscription.cours')
                ->orderByDesc('issued_at')
                ->get();

        return view('livewire.etudiant.badges', [
            'badges' => $badgeData['earned'],
            'lockedBadges' => $badgeData['locked'],
            'certificats' => $certificats,
            'leaderboard' => $leaderboard,
            'metrics' => $metrics,
        ])
            ->layout('layouts.etudiant');
    }
}
