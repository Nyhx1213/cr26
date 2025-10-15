<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Str;


class ControlleurAdministrateur extends Controller
{

##
##     Affichage des pages des utilisateurs.
##

    function page_AffichageUtils(){
        return view('pages.affichageUtil_admin');
    }
    
    function page_DetailUtil(){
        return view('pages.detailUtil_admin');
    }

    function page_SuppUtil(){
        return view('pages.supprimerUtil_admin');
    }

    function page_ModifUtil(){
        return view('pages.modificationUtil_admin');
    }

    function page_CreationUtil(){
        //Retourne un objet contenant tout les rôles
        $roles = Role::all();
        return view('pages.creationUtil_admin', compact('roles'));
    }

##
##  Fonctions CRUD 
##

    //Géneration d'utilisateur 
    public function ajouterUtil(Request $request)
    {
        //name => le nom de la personne
        //Informations pour la table User
        $validerUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'role' => ['required', 'integer']
        ]);


        $role = $validerUser['role'];
        $request['password'] = Str::random(16);
        $validerUser['password'] = Hash::make($validerUser['password']);

        if (Role::find($validerUser['role']))
        {
            User::create([
                'name' => $validerUser['name'],
                'email' => $validerUser['email'],
                'password' => $validerUser['password']
            ]);
            
            event(new Registered($user));
            
            Utilisateur::create([
                'id' => $user->id,
                'nom' => $validerUser['name'],
                'prenom' => $validerUser['prenom']
            ]);

            Engager::create([
                'id_utilisateur' => $user->id,
                'id_role' => $validerUser['role']
            ]);
            return redirect()->route(page_CreationUtil())
            ->with('success', 'Post created successfully.');
        }
    }

}
