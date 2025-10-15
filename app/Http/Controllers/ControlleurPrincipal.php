<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ControlleurPrincipal extends Controller
{
    function pageAccueil() {
        return view('pages.accueil');
    }
    
    function pageMentions() {
        return view('pages.mentions');
    }
}