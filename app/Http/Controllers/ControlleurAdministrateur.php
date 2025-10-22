<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Concour;
use App\Models\User;
use App\Models\Utilisateur;
use App\Models\Genre;
use App\Models\Engager;
use App\Mail\MailInfoUtil;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Str;


class ControlleurAdministrateur extends Controller
{

##
##     Affichage des pages des utilisateurs.
##

    function page_AffichageUtils(){
        $lesUtilisateurs = DB::table('users');
        return view('administrateur.affichageUtil_admin', compact('lesUtilisateurs'));
    }
    
    function page_DetailUtil($id){
        $utilisateur = User::find($id);
        return view('administrateur.detailUtil_admin', compact($id));
    }

    function page_SuppUtil(){
        return view('administrateur.supprimerUtil_admin');
    }

    function page_ModifUtil(){
        return view('administrateur.modificationUtil_admin');
    }

    function page_CreationUtil(){
        //Retourne un objet contenant tout les rôles
        $genres = Genre::all();
        $roles = Role::all();
        $concours = Concour::all();
        return view('administrateur.creationUtil_admin', compact('roles', 'genres', 'concours'));
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
            'role' => ['required', 'integer'],
            'prenom' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:1'],
            'concour' => ['required', 'integer']
        ]);

        $motdepasseEnClaire = Str::random(16);
        $request['password'] = $motdepasseEnClaire;
        $validerUser['password'] = Hash::make($request['password']);

        if (Role::find($validerUser['role']) && Genre::find($validerUser['genre']) && Concour::find($validerUser['concour']))
        {
            if(strlen($validerUser['prenom']) >= 3){
                $nameUser = $validerUser['prenom'][0].$validerUser['prenom'][1].$validerUser['prenom'][2];
            }
            else{
                $nameUser = $validerUser['prenom'];
            }

           $user = User::create([
                'name' => $nameUser.'.'.$validerUser['name'],
                'email' => $validerUser['email'],
                'password' => $validerUser['password']
            ]);
            
            event(new Registered($user));
            
            Utilisateur::create([
                'id' => $user->id,
                'nom' => $validerUser['name'],
                'prenom' => $validerUser['prenom'],
                'code_statut' => 'N',
                'code_genre' => $validerUser['genre']
            ]);

            Engager::create([
                'id_utilisateur' => $user->id,
                'id_role' => $validerUser['role'],
                'id_concours' => $validerUser['concour']
                //Ajouter un concours ??? )(problématic dans certain cas à voir avec monsieur henry)
            ]);

            Mail::to($user->email)->send(new MailInfoUtil($user, $motdepasseEnClaire));
            
            return redirect()->route('administrateur.creationUtil')
            ->with('success', 'Utilisateur créé et email envoyé');
        }
    }

}
