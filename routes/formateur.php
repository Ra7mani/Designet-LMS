<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Formateur\Dashboard;
use App\Livewire\Formateur\MesCours;
use App\Livewire\Formateur\CreerCours;
use App\Livewire\Formateur\MesEtudiants;
use App\Livewire\Formateur\Forum;
use App\Livewire\Formateur\Planning;
use App\Livewire\Formateur\Quiz;
use App\Livewire\Formateur\Statistiques;
use App\Livewire\Formateur\Profil;

Route::middleware(['auth', 'verified', 'role:formateur'])
    ->prefix('formateur')
    ->name('formateur.')
    ->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/mes-cours', MesCours::class)->name('mes-cours');
    Route::get('/creer-cours', CreerCours::class)->name('creer-cours');
    Route::get('/cours/{id}/editer', CreerCours::class)->name('editer-cours');
    Route::get('/etudiants', MesEtudiants::class)->name('etudiants');
    Route::get('/forum', Forum::class)->name('forum');
    Route::get('/planning', Planning::class)->name('planning');
    Route::get('/quiz', Quiz::class)->name('quiz');
    Route::get('/statistiques', Statistiques::class)->name('statistiques');
    Route::get('/profil', Profil::class)->name('profil');

    // API routes for AJAX
    Route::get('/api/search', 'App\Http\Controllers\Formateur\SearchController@search')->name('api.search');
    Route::get('/api/notifications', 'App\Http\Controllers\Formateur\NotificationsController@index')->name('api.notifications');

});