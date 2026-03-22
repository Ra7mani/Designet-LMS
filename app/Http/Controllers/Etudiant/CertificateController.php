<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateController extends Controller
{
    public function download(Certificat $certificat): BinaryFileResponse
    {
        $user = auth()->user();

        abort_unless(
            $user && $certificat->inscription && (int) $certificat->inscription->etudiant_id === (int) $user->id,
            403
        );

        $relativePath = $certificat->pdf_url
            ? ltrim(str_replace('/storage/', '', $certificat->pdf_url), '/')
            : null;

        abort_unless($relativePath && \Storage::disk('public')->exists($relativePath), 404);

        $filename = 'certificat-'.$certificat->certificate_number.'.pdf';

        return response()->download(storage_path('app/public/'.$relativePath), $filename);
    }
}
