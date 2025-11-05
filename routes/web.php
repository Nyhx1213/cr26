<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlleurPrincipal;
use App\Http\Controllers\UserController;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Middleware\IsAdmin;

//URL::forceScheme('https');

Route::get('/', [ControlleurPrincipal::class, 'page_accueil'])->name('accueil');

Route::get('/mentions_Legals', [ControlleurPrincipal::class, 'page_mentions']); 

Route::get('/Liste_Utilisateurs', [UserController::class, 'page_affichage_utils'])->name('administrateur.affichage_utils');//->middleware(IsAdmin::class);

Route::get('/Detail_Utilisateur/{idUtil}', [UserController::class, 'page_detail_util'])->name('administrateur.detail_util');//->middleware(IsAdmin::class);

Route::get('/Modification_Utilisateur/{idUtil}', [UserController::class, 'page_modif_util'])->name('administrateur.modification_util');//->middleware(IsAdmin::class);

Route::put('/Modification_Utilisateur/{idUtil}', [UserController::class, 'modification_util'])->name('administrateur.action_modifier_util');//->middleware(IsAdmin::class);

Route::get('/Genération_Utilisateur', [UserController::class, 'page_creation_util'])->name('administrateur.creation_util');//->middleware(IsAdmin::class);

Route::post('/Genération_Utilisateur', [UserController::class, 'ajouter_util'])->name('administrateur.ajouter_util');//->middleware(IsAdmin::class);

Route::delete('/Suprimmer_Utilisateur/{idUtil}', [UserController::class, 'supprimer_util'])->name('administrateur.supprimer_util');//->middleware(IsAdmin::class);

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
