<?php

namespace App\Observers;

use App\Enums\EnrollStatus;
use App\Models\Inscription;
use App\Services\GamificationService;

class InscriptionObserver
{
    public function saved(Inscription $inscription): void
    {
        $isEligible = (float) $inscription->progress >= 100
            || $inscription->status === EnrollStatus::Completed
            || $inscription->status === 'completed';

        if (!$isEligible || !$inscription->etudiant) {
            return;
        }

        app(GamificationService::class)->syncRewardsForUser($inscription->etudiant);
    }
}
