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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        //Informations pour la table Utilisateur
        $validerUtilisateur = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'role' => ['required', 'int']
        ]);

        $role = $validerUtilisateur->role;

        $request['password'] = Hash::make($validated['password']);

        if($role->belongsTo(Role::class, 'id_role')){
            event(new Registered($user = User::create($validated)));

            Utilisateur::create([
                'id' => $user->id,
                'nom' => $validerUtilisateur->name,
                'prenom' => $validerUtilisater->prenom
            ]);

            Engager::create([
                'id_utilisateur' => $user->id,
                'id_role' => $role
            ]);
        }

    }

}
