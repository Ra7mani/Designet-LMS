<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats Quiz</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #6b7280; margin-bottom: 14px; }
        .stats { margin: 10px 0 16px; }
        .stats span { margin-right: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 7px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>{{ $quiz->title }}</h1>
    <div class="meta">Cours: {{ $quiz->cours->title ?? 'Cours' }}</div>

    @if(!empty($stats))
        <div class="stats">
            <span><strong>Tentatives:</strong> {{ $stats['attempts_count'] ?? 0 }}</span>
            <span><strong>Score moyen:</strong> {{ $stats['average_score'] ?? 0 }}%</span>
            <span><strong>Réussite:</strong> {{ $stats['success_rate'] ?? 0 }}%</span>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Email</th>
                <th>Score</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attempts as $attempt)
                <tr>
                    <td>{{ $attempt->user->name ?? 'Étudiant' }}</td>
                    <td>{{ $attempt->user->email ?? '' }}</td>
                    <td>{{ $attempt->score_percent }}%</td>
                    <td>{{ $attempt->status }}</td>
                    <td>{{ optional($attempt->completed_at ?? $attempt->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune tentative.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
