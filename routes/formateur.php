<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:formateur'])
    ->prefix('formateur')
    ->name('formateur.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('livewire.formateur.dashboard');
    })->name('dashboard');

});