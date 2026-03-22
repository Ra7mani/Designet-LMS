<?php

namespace App\Console\Commands;

use App\Models\Certificat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCertificatePdf extends Command
{
    protected $signature = 'certificat:generate-pdf {id}';
    protected $description = 'Generate PDF for a certificat';

    public function handle()
    {
        $certificatId = $this->argument('id');
        $certificat = Certificat::find($certificatId);

        if (!$certificat) {
            $this->error("Certificat not found: {$certificatId}");
            return 1;
        }

        $certificat->load(['inscription.etudiant', 'inscription.cours']);

        $courseTitle = $certificat->inscription->cours->title ?? 'Cours';
        $studentName = $certificat->inscription->etudiant->name ?? 'Etudiant';
        $issuedDate = optional($certificat->issued_at)->format('d/m/Y') ?? now()->format('d/m/Y');

        $pdf = Pdf::loadView('pdf.certificate', [
            'certificat' => $certificat,
            'courseTitle' => $courseTitle,
            'studentName' => $studentName,
            'issuedDate' => $issuedDate,
        ]);

        $path = 'certificates/certificate-' . $certificat->id . '.pdf';
        Storage::disk('public')->put($path, $pdf->output());

        $certificat->update([
            'pdf_url' => '/storage/' . $path,
        ]);

        $this->info("✅ PDF generated successfully!");
        $this->line("Path: {$path}");
        $this->line("Size: " . Storage::disk('public')->size($path) . " bytes");

        return 0;
    }
}
