<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlleurPrincipal;
use App\Http\Controllers\ControlleurAdministrateur;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;

//URL::forceScheme('https');

Route::get('/', [ControlleurPrincipal::class, 'page_accueil']);

Route::get('/accueil', [ControlleurPrincipal::class, 'page_accueil']);

Route::get('/mentions_Legals', [ControlleurPrincipal::class, 'page_mentions']); 

Route::get('/administrateur-affichage', [ControlleurAdministrateur::class, 'page_affichage_utils'])->name('administrateur.affichage_utils');

Route::get('/administrateur-detail/{idUtil}', [ControlleurAdministrateur::class, 'page_detail_util'])->name('administrateur.detail_util');

Route::get('/administrateur-modification/{idUtil}', [ControlleurAdministrateur::class, 'page_modif_util'])->name('administrateur.modification_util');

Route::put('/administrateur-modification/{idUtil}', [ControlleurAdministrateur::class, 'modification_util'])->name('administrateur.action_modifier_util');

Route::get('/administrateur-creation', [ControlleurAdministrateur::class, 'page_creation_util'])->name('administrateur.creation_util');

Route::post('/administrateur-creation', [ControlleurAdministrateur::class, 'ajouter_util'])->name('administrateur.ajouter_util');

Route::delete('/administrateur-detail/{idUtil}', [ControlleurAdministrateur::class, 'supprimer_util'])->name('administrateur.supprimer_util');

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
