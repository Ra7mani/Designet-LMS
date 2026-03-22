<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Certificat disponible</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
  <h2>Felicitations {{ $certificat->inscription->etudiant->name ?? '' }} !</h2>
  <p>
    Ton certificat pour le cours
    <strong>{{ $certificat->inscription->cours->title ?? 'Cours' }}</strong>
    est maintenant disponible.
  </p>
  <p>
    Numero de certificat: <strong>{{ $certificat->certificate_number }}</strong><br>
    Date d'emission: <strong>{{ optional($certificat->issued_at)->format('d/m/Y') }}</strong>
  </p>
  <p>
    <a href="{{ $downloadUrl }}" style="display:inline-block;padding:10px 16px;background:#1f2937;color:#ffffff;text-decoration:none;border-radius:6px;">
      Telecharger le certificat PDF
    </a>
  </p>
</body>
</html>
