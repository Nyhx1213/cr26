<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PrincipalControlleur extends Controller
{
    function accueil() {
        return view('administrateur.accueil');
    }
    
    function mentions() {
        return view('administrateur.mentions');
    }
}