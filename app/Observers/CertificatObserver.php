<?php

namespace App\Observers;

use App\Actions\GenerateCertificatePdfAction;
use App\Models\Certificat;

class CertificatObserver
{
    public function created(Certificat $certificat): void
    {
        // Générer le PDF automatiquement après la création
        if (!$certificat->pdf_url) {
            app(GenerateCertificatePdfAction::class)->execute($certificat);
        }
    }
}
