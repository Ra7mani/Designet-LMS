<?php

namespace App\Mail;

use App\Models\Certificat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Certificat $certificat) {}

    public function envelope(): Envelope
    {
        $courseTitle = $this->certificat->inscription->cours->title ?? 'votre cours';

        return new Envelope(
            subject: 'Votre certificat est disponible - '.$courseTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-issued',
            with: [
                'certificat' => $this->certificat,
                'downloadUrl' => route('etudiant.certificats.download', $this->certificat),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
