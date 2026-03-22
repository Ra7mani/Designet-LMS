<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('welcome');
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