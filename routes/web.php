<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalControlleur;
use App\Http\Controllers\UserController;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Middleware\IsAdmin;

//URL::forceScheme('https');

Route::get('/', [PrincipalControlleur::class, 'accueil'])->name('accueil');

Route::get('/accueil', [PrincipalControlleur::class, 'accueil'])->name('accueil');

Route::get('/mentions', [PrincipalControlleur::class, 'mentions']); 

Route::get('/admin/liste-utilisateurs', [UserController::class, 'listeUtilisateurs'])->name('administrateur.liste-utilisateurs');//->middleware(IsAdmin::class);

Route::get('/admin/detail-utilisateur/{idUtil}', [UserController::class, 'detailUtilisateur'])->name('administrateur.detail-utilisateur');//->middleware(IsAdmin::class);

Route::get('/admin/modification-utilisateur/{idUtil}', [UserController::class, 'formulaireModificationUtil'])->name('administrateur.modification-utilisateur');//->middleware(IsAdmin::class);

Route::put('/admin/modification-utilisateur/{idUtil}', [UserController::class, 'modificationUtilisateur'])->name('administrateur.action-modification');//->middleware(IsAdmin::class);

Route::delete('/admin/suppression-utilisateur/{idUtil}', [UserController::class, 'suppressionUtilisateur'])->name('administrateur.supprimer-utilisateur');//->middleware(IsAdmin::class);

Route::get('/admin/generation-utilisateur', [UserController::class, 'formulaireGeneration'])->name('administrateur.generation-utilisateur');//->middleware(IsAdmin::class);

Route::post('/admin/generation-utilisateur', [UserController::class, 'ajouterUtilisateur'])->name('administrateur.ajouter-utilisateur');//->middleware(IsAdmin::class);

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
