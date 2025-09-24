<?php

use Illuminate\Support\Facades\Route;


Route::view ('/', 'acueil');

Route::view ('/acueil', 'acueil');

Route::view ('/Mentions_Legals', 'mentions');

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
