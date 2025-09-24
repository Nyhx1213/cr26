<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControlleurPrincipal;

Route::get('/', [ControlleurPrincipal::class, 'pageAcueil']);
Route::get('/Mentions_Legals', [ControlleurPrincipal::class, 'pageMentions']);

Route::get('/welcome', function () {
    return view('welcome');
});

