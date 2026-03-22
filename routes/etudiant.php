<?php

use App\Livewire\Etudiant\Catalogue;
use App\Livewire\Etudiant\Dashboard;
use App\Livewire\Etudiant\DetailCours;
use App\Livewire\Etudiant\MesCours;
use App\Livewire\Etudiant\Progression;
use App\Livewire\Etudiant\Badges;
use App\Livewire\Etudiant\Forum;
use App\Livewire\Etudiant\Profil;
use App\Livewire\Etudiant\Parametres;
use App\Livewire\Etudiant\QuizExamens;
use App\Livewire\Etudiant\Planning;
use App\Http\Controllers\Etudiant\CertificateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:etudiant'])
    ->prefix('etudiant')
    ->name('etudiant.')
    ->group(function () {

    Route::get('/dashboard',    Dashboard::class)->name('dashboard');
    Route::get('/catalogue',    Catalogue::class)->name('catalogue');
    Route::get('/cours/{id}',   DetailCours::class)->name('cours.detail');
    Route::get('/mes-cours',    MesCours::class)->name('mes-cours');
    Route::get('/progression',  Progression::class)->name('progression');
    Route::get('/badges',       Badges::class)->name('badges');
    Route::get('/certificats/{certificat}/download', [CertificateController::class, 'download'])
        ->name('certificats.download');
    Route::get('/profil',       Profil::class)->name('profil');
    Route::get('/quiz',         QuizExamens::class)->name('quiz');
    Route::get('/forum',        Forum::class)->name('forum');

    // Pages simples (à développer plus tard)
    Route::get('/planning',     Planning::class)->name('planning');
    Route::get('/parametres',   Parametres::class)->name('parametres');
});