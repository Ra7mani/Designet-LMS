<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Certificat {{ $certificat->certificate_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f3ff;
            padding: 40px 20px;
        }

        .certificate {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(30, 27, 75, 0.2);
        }

        /* Header Gradient */
        .certificate-header {
            background: linear-gradient(135deg, #1E1B4B 0%, #4C1D95 40%, #7C3AED 100%);
            padding: 60px 40px;
            text-align: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .certificate-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .certificate-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .cert-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
            position: relative;
            z-index: 1;
        }

        .cert-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        .cert-subtitle {
            font-size: 14px;
            opacity: 0.85;
            position: relative;
            z-index: 1;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Content */
        .certificate-content {
            padding: 60px 40px;
            text-align: center;
        }

        .cert-label {
            font-size: 13px;
            color: #7C3AED;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .cert-text {
            font-size: 18px;
            color: #6B7280;
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .student-name {
            font-size: 48px;
            font-weight: 900;
            color: #1E1B4B;
            margin: 30px 0;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .course-name {
            font-size: 24px;
            font-weight: 700;
            color: #4C1D95;
            background: #F3E8FF;
            display: inline-block;
            padding: 16px 32px;
            border-radius: 12px;
            margin: 24px 0;
            letter-spacing: 0.3px;
        }

        .divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #7C3AED, transparent);
            margin: 40px auto;
        }

        .cert-footer {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            letter-spacing: 0.05em;
        }

        .cert-number {
            font-size: 10px;
            color: #D1D5DB;
            margin-top: 8px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <!-- Header with Gradient -->
        <div class="certificate-header">
            <span class="cert-icon">🎓</span>
            <div class="cert-title">Certificat</div>
            <div class="cert-subtitle">De Realisation</div>
        </div>

        <!-- Content -->
        <div class="certificate-content">
            <div class="cert-label">Attestation Officielle</div>

            <div class="cert-text">Ce document certifie que</div>

            <div class="student-name">{{ $studentName }}</div>

            <div class="divider"></div>

            <div class="cert-text">a complete avec succes le cours</div>

            <div class="course-name">{{ $courseTitle }}</div>

            <div class="cert-footer">
                DesignLMS · Plateforme de Formation
                <div class="cert-number">{{ $certificat->certificate_number }}</div>
            </div>
        </div>
    </div>
</body>
</html>
