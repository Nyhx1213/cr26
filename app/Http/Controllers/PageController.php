<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    function home() {
        return view('accueil');
    }
    
    function mentions() {
        return view('mentions');
    }
}