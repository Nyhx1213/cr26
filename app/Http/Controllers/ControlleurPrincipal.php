<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ControlleurPrincipal extends Controller
{
    function page_accueil() {
        return view('administrateur.accueil');
    }
    
    function page_mentions() {
        return view('administrateur.mentions');
    }
}