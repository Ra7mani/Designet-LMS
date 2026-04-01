<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Statistiques Formateur</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        h2 { font-size: 14px; margin: 16px 0 8px; }
        .meta { color: #6b7280; margin-bottom: 14px; }
        .kpi { margin: 8px 0 12px; }
        .kpi span { margin-right: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 7px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Rapport Statistiques Formateur</h1>
    <div class="meta">Période: {{ $periodLabel }} · Généré le {{ now()->format('d/m/Y H:i') }}</div>

    <div class="kpi">
        <span><strong>Revenus totaux:</strong> {{ number_format($totalRevenue) }}€</span>
        <span><strong>Revenus période:</strong> {{ number_format($periodRevenue) }}€</span>
        <span><strong>Nouveaux inscrits:</strong> {{ $newStudents }}</span>
        <span><strong>Note moyenne:</strong> {{ number_format($averageRating, 1) }}</span>
        <span><strong>Complétion:</strong> {{ $avgCompletion }}%</span>
    </div>

    <div class="kpi">
        <span><strong>Rétention:</strong> {{ $retention }}%</span>
        <span><strong>Abandon:</strong> {{ $dropout }}%</span>
    </div>

    <h2>Classement des cours</h2>
    <table>
        <thead>
            <tr>
                <th>Cours</th>
                <th>Revenus</th>
                <th>Note</th>
                <th>Inscriptions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course['title'] }}</td>
                    <td>{{ number_format($course['revenue']) }}€</td>
                    <td>{{ number_format($course['rating'], 1) }}</td>
                    <td>{{ $course['enrollments'] }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucun cours.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Leçons les plus vues</h2>
    <table>
        <thead>
            <tr><th>Leçon</th><th>Vues</th></tr>
        </thead>
        <tbody>
            @forelse($lessons['viewed'] as $lesson)
                <tr><td>{{ $lesson['title'] }}</td><td>{{ $lesson['views'] }}</td></tr>
            @empty
                <tr><td colspan="2">Aucune donnée.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Leçons les plus abandonnées</h2>
    <table>
        <thead>
            <tr><th>Leçon</th><th>Abandons</th></tr>
        </thead>
        <tbody>
            @forelse($lessons['abandoned'] as $lesson)
                <tr><td>{{ $lesson['title'] }}</td><td>{{ $lesson['abandons'] }}</td></tr>
            @empty
                <tr><td colspan="2">Aucune donnée.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
