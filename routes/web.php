<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlleurPrincipal;
use App\Http\Controllers\ControlleurAdministrateur;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;

//URL::forceScheme('https');

Route::get('/', [ControlleurPrincipal::class, 'pageAccueil']);

Route::get('/accueil', [ControlleurPrincipal::class, 'pageAccueil']);

Route::get('/mentions_Legals', [ControlleurPrincipal::class, 'pageMentions']); 

Route::get('/administrateur-affichage', [ControlleurAdministrateur::class, 'page_AffichageUtils'])->name('administrateur.affichageUtils');

Route::get('/administrateur-detail/{idUtil}', [ControlleurAdministrateur::class, 'page_DetailUtil'])->name('administrateur.detailUtil');

Route::get('/administrateur-suppression', [ControlleurAdministrateur::class, 'page_SuppUtil']);

Route::get('/administrateur-modification', [ControlleurAdministrateur::class, 'page_ModifUtil']);

Route::get('/administrateur-creation', [ControlleurAdministrateur::class, 'page_CreationUtil'])->name('administrateur.creationUtil');

Route::post('/administrateur-creation', [ControlleurAdministrateur::class, 'ajouterUtil'])->name('administrateur.ajouterUtil');

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
