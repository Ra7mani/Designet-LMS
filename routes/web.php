<?php

use App\Enums\CourseStatus;
use App\Enums\RoleType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Avis;
use App\Models\Certificat;
use App\Models\Cours;
use App\Models\User;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    $studentsCount = User::where('role', RoleType::Etudiant)->count();
    $coursesCount = Cours::where('status', CourseStatus::Published)->count();
    $certificatesCount = Certificat::count();
    $averageRatingRaw = Cours::where('status', CourseStatus::Published)->avg('rating');

    $stats = [
        'studentsCount' => $studentsCount,
        'coursesCount' => $coursesCount,
        'certificatesCount' => $certificatesCount,
        'averageRating' => $averageRatingRaw ? number_format((float) $averageRatingRaw, 1) : '0.0',
    ];

    if ($studentsCount === 0 && $coursesCount === 0 && $certificatesCount === 0 && $averageRatingRaw === null) {
        $stats = [
            'studentsCount' => 3208,
            'coursesCount' => 47,
            'certificatesCount' => 312,
            'averageRating' => '4.8',
        ];
    }

    $courseStyles = [
        ['emoji' => '💡', 'cover_gradient' => 'linear-gradient(135deg,#EDE9FE,#DDD6FE)', 'category_color' => '#7C3AED'],
        ['emoji' => '🖥️', 'cover_gradient' => 'linear-gradient(135deg,#CCFBF1,#A7F3D0)', 'category_color' => '#0D9488'],
        ['emoji' => '🎬', 'cover_gradient' => 'linear-gradient(135deg,#FEF3C7,#FDE68A)', 'category_color' => '#D97706'],
        ['emoji' => '🎨', 'cover_gradient' => 'linear-gradient(135deg,#E0F2FE,#BAE6FD)', 'category_color' => '#0284C7'],
    ];

    $courses = Cours::query()
        ->where('status', CourseStatus::Published)
        ->with(['formateur:id,name', 'categorie:id,name'])
        ->withCount('inscriptions')
        ->orderByDesc('rating')
        ->orderByDesc('id')
        ->limit(4)
        ->get()
        ->values()
        ->map(function (Cours $course, int $index) use ($courseStyles) {
            $style = $courseStyles[$index % count($courseStyles)];
            $price = (float) $course->price;
            $isFree = $price <= 0;
            $rating = (float) ($course->rating ?? 0);

            if ($isFree) {
                $badgeText = 'Gratuit';
                $badgeColor = '#0284C7';
            } elseif ($rating >= 4.8) {
                $badgeText = 'Bestseller';
                $badgeColor = '#7C3AED';
            } elseif ($course->created_at && $course->created_at->isAfter(now()->subDays(30))) {
                $badgeText = 'Nouveau';
                $badgeColor = '#0D9488';
            } else {
                $badgeText = 'Premium';
                $badgeColor = '#DB2777';
            }

            return [
                'title' => $course->title,
                'trainer_name' => $course->formateur?->name ?? 'Formateur DesignLMS',
                'level' => $course->level ?: 'Tous niveaux',
                'price' => $isFree ? 'Gratuit' : number_format($price, 0, ',', ' ') . '€',
                'rating' => number_format($rating > 0 ? $rating : 4.7, 1),
                'reviews_count' => $course->inscriptions_count,
                'category' => $course->categorie?->name ?? 'Formation',
                'emoji' => $style['emoji'],
                'badge_text' => $badgeText,
                'badge_color' => $badgeColor,
                'cover_gradient' => $style['cover_gradient'],
                'category_color' => $style['category_color'],
            ];
        })
        ->all();

    if (empty($courses)) {
        $courses = [
            [
                'title' => 'UX/UI Design Avancé',
                'trainer_name' => 'Karim Benzali',
                'level' => 'Intermédiaire',
                'price' => '49€',
                'rating' => '4.9',
                'reviews_count' => 312,
                'category' => 'Design',
                'emoji' => '💡',
                'badge_text' => 'Bestseller',
                'badge_color' => '#7C3AED',
                'cover_gradient' => 'linear-gradient(135deg,#EDE9FE,#DDD6FE)',
                'category_color' => '#7C3AED',
            ],
            [
                'title' => 'Figma Masterclass',
                'trainer_name' => 'Karim Benzali',
                'level' => 'Débutant',
                'price' => '39€',
                'rating' => '4.8',
                'reviews_count' => 198,
                'category' => 'Design',
                'emoji' => '🖥️',
                'badge_text' => 'Nouveau',
                'badge_color' => '#0D9488',
                'cover_gradient' => 'linear-gradient(135deg,#CCFBF1,#A7F3D0)',
                'category_color' => '#0D9488',
            ],
            [
                'title' => 'Motion Design CSS',
                'trainer_name' => 'Leila Benhamed',
                'level' => 'Avancé',
                'price' => '45€',
                'rating' => '4.7',
                'reviews_count' => 156,
                'category' => 'Dev Web',
                'emoji' => '🎬',
                'badge_text' => 'Premium',
                'badge_color' => '#DB2777',
                'cover_gradient' => 'linear-gradient(135deg,#FEF3C7,#FDE68A)',
                'category_color' => '#D97706',
            ],
            [
                'title' => 'Fondamentaux UX Design',
                'trainer_name' => 'Karim Benzali',
                'level' => 'Débutant',
                'price' => 'Gratuit',
                'rating' => '4.7',
                'reviews_count' => 521,
                'category' => 'Design',
                'emoji' => '🎨',
                'badge_text' => 'Gratuit',
                'badge_color' => '#0284C7',
                'cover_gradient' => 'linear-gradient(135deg,#E0F2FE,#BAE6FD)',
                'category_color' => '#0284C7',
            ],
        ];
    }

    $reviewGradients = [
        'background:linear-gradient(135deg,#DB2777,#F472B6)',
        'background:linear-gradient(135deg,#0284C7,#38BDF8)',
        'background:linear-gradient(135deg,#059669,#34D399)',
    ];

    $testimonials = Avis::query()
        ->approved()
        ->with(['inscription.etudiant:id,name', 'inscription.cours:id,title'])
        ->latest()
        ->limit(3)
        ->get()
        ->values()
        ->map(function (Avis $avis, int $index) use ($reviewGradients) {
            $name = $avis->inscription?->etudiant?->name ?? 'Membre DesignLMS';
            $courseTitle = $avis->inscription?->cours?->title;
            $initials = Str::of($name)
                ->explode(' ')
                ->take(2)
                ->map(fn (string $word) => Str::upper(Str::substr($word, 0, 1)))
                ->implode('');

            return [
                'name' => $name,
                'role' => $courseTitle ? "🎓 Étudiant · {$courseTitle}" : '🎓 Apprenant DesignLMS',
                'comment' => $avis->comment ?: "Une excellente expérience d'apprentissage sur DesignLMS.",
                'initials' => $initials ?: 'DL',
                'gradientStyle' => $reviewGradients[$index % count($reviewGradients)],
                'stars' => max(1, min(5, (int) ($avis->rating ?? 5))),
            ];
        })
        ->all();

    if (empty($testimonials)) {
        $testimonials = [
            [
                'name' => 'Amira Mansouri',
                'role' => '🎓 Étudiante · UX/UI Designer',
                'comment' => "Cours exceptionnel ! Karim explique avec une clarté remarquable. Les exercices pratiques sont très bien pensés.",
                'initials' => 'AM',
                'gradientStyle' => 'background:linear-gradient(135deg,#DB2777,#F472B6)',
                'stars' => 5,
            ],
            [
                'name' => 'Karim Benzali',
                'role' => '🧑‍🏫 Formateur UX/UI',
                'comment' => "En tant que formateur, la plateforme est un vrai game-changer. Je gère mes cours, mes étudiants et mes revenus depuis un seul endroit.",
                'initials' => 'KB',
                'gradientStyle' => 'background:linear-gradient(135deg,#0284C7,#38BDF8)',
                'stars' => 5,
            ],
            [
                'name' => 'Nadia Drissi',
                'role' => '🎓 Étudiante · Figma Masterclass',
                'comment' => "Les sessions live sont incroyables. On peut poser des questions en temps réel et revoir les enregistrements ensuite.",
                'initials' => 'ND',
                'gradientStyle' => 'background:linear-gradient(135deg,#059669,#34D399)',
                'stars' => 5,
            ],
        ];
    }

    return view('landing', [
        ...$stats,
        'courses' => $courses,
        'testimonials' => $testimonials,
    ]);
})->name('home');

// Routes par rôle
require __DIR__.'/admin.php';
require __DIR__.'/formateur.php';
require __DIR__.'/etudiant.php';

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->isFormateur()) {
        return redirect()->route('formateur.dashboard');
    } else {
        return redirect()->route('etudiant.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Logout route
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');
