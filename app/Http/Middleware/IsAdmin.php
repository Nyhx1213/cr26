<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Requetes\RequeteSupport;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('Erreur', 'Veuillez vous connecter');
        }

        $role = RequeteSupport::recupRole($user->id);

        if (!$role || $role->code != "ADM"){
            return redirect()->route('home')->with('Erreur', 'Refus d\'acces : Vous n\'etes pas un administrateur');
        }
        
        return $next($request);
    }
}
