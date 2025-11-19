<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Middleware\IsAdmin;
use Livewire\Volt\Volt;

//URL::forceScheme('https');

// Accueil
Route::get('/', [PageController::class, 'home'])->name('home');

// Collèges
Route::get('/colleges/eleves', [PageController::class, 'eleves'])->name('colleges.eleves');
Route::get('/colleges/equipe', [PageController::class, 'equipe'])->name('colleges.equipe');

// Épreuves
Route::get('/epreuves', [PageController::class, 'epreuves'])->name('epreuves.index');

// Classement
Route::get('/classement', [PageController::class, 'classement'])->name('classement.index');

// Édition
Route::get('/edition/2024', [PageController::class, 'show2024'])->name('edition.2024');
Route::get('/edition/2025', [PageController::class, 'show2025'])->name('edition.2025');

// Saisie Note
Route::get('/saisie-note', [PageController::class, 'saisie-note'])->name('saisieNote.index');

// Page Gestion
Route::prefix('gestion')->group(function () {
    Route::get('/epreuves', [PageController::class, 'epreuves'])->name('gestion.epreuves');
    Route::get('/colleges', [PageController::class, 'colleges'])->name('gestion.colleges');
    Route::get('/abonnement', [PageController::class, 'abonnement'])->name('gestion.abonnement');
    Route::get('/role', [PageController::class, 'role'])->name('gestion.role');
    Route::get('/edition', [PageController::class, 'edition'])->name('gestion.edition');
    Route::get('/exportation', [PageController::class, 'exportation'])->name('gestion.exportation');
    Route::get('/modification', [PageController::class, 'modification'])->name('gestion.modification');
});

// Page Admin
Route::prefix('admin')->group(function () {
    Route::get('/genre', [PageController::class, 'genre'])->name('admin.genre');
    Route::get('/pays', [PageController::class, 'pays'])->name('admin.pays');
    Route::get('/utilisateurs', [PageController::class, 'utilisateurs'])->name('admin.utilisateurs');
});

Route::middleware([IsAdmin::class])->group(function () {
Route::get('/admin/liste-utilisateurs', [UserController::class, 'listeUtilisateurs'])->name('administrateur.liste-utilisateurs');
Route::get('/admin/detail-utilisateur/{idUtil}', [UserController::class, 'detailUtilisateur'])->name('administrateur.detail-utilisateur');
Route::get('/admin/modification-utilisateur/{idUtil}', [UserController::class, 'formulaireModificationUtil'])->name('administrateur.modification-utilisateur');
Route::put('/admin/modification-utilisateur/{idUtil}', [UserController::class, 'modificationUtilisateur'])->name('administrateur.action-modification');
Route::delete('/admin/suppression-utilisateur/{idUtil}', [UserController::class, 'suppressionUtilisateur'])->name('administrateur.supprimer-utilisateur');
Route::get('/admin/generation-utilisateur', [UserController::class, 'formulaireGeneration'])->name('administrateur.generation-utilisateur');
Route::post('/admin/generation-utilisateur', [UserController::class, 'ajouterUtilisateur'])->name('administrateur.ajouter-utilisateur');
});

// Connexion
Volt::route('login', 'pages.auth.login')->name('login');
Volt::route('register', 'pages.auth.register')->name('register');
Volt::route('logout', 'pages.auth.logout')->name('logout');

Route::view('reset-password', 'profile')
    ->middleware(['auth'])
    ->name('reset-password');

require __DIR__.'/auth.php';

Route::view('error', 'erreur');