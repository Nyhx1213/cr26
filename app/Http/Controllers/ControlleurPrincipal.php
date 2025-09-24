<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ControlleurPrincipal extends Controller
{
    function pageAcueil() {
        return view('acueil');
    }
    
    function pageMentions() {
        return view('mentions');
    }
}
