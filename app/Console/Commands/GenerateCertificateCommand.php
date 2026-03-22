<?php

namespace App\Console\Commands;

use App\Actions\GenerateCertificatePdfAction;
use App\Models\Certificat;
use Illuminate\Console\Command;

class GenerateCertificateCommand extends Command
{
    protected $signature = 'certificate:generate {certificat_id} {--force}';
    protected $description = 'Générer ou régénérer le PDF d\'un certificat';

    public function handle(): int
    {
        $certificatId = $this->argument('certificat_id');
        $force = $this->option('force');

        $certificat = Certificat::find($certificatId);

        if (!$certificat) {
            $this->error("Certificat #{$certificatId} non trouvé.");
            return self::FAILURE;
        }

        if ($certificat->pdf_url && !$force) {
            $this->warn("Le certificat a déjà un PDF. Utilisez --force pour régénérer.");
            return self::FAILURE;
        }

        try {
            app(GenerateCertificatePdfAction::class)->execute($certificat);
            $this->info("✓ Certificat #{$certificatId} généré avec succès.");
            $this->line("PDF: {$certificat->fresh()->pdf_url}");
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erreur: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
