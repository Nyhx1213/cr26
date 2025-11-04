<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Concour;
use App\Models\User;
use App\Models\College;
use App\Models\Equipe;
use App\Models\Utilisateur;
use App\Models\Genre;
use App\Models\Engager;
use App\Mail\MailInfoUtil;
use App\Mail\ModificationUtil;
use App\Requetes\RequeteSupport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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

    function page_affichage_utils()
    {
        $les_utilisateurs = DB::table('users')
            ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
            ->join('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
            ->join('roles', 'engager.id_role', '=', 'roles.id')
            ->select(
                    'users.*',
                    'utilisateurs.*',
                    'engager.*',
                    'roles.nom as role')// Select permet de renommer les valeurs des objets dans la collection.
            ->orderBy('users.id')
            ->paginate(30);

        return view('administrateur.affichage_util_admin', compact('les_utilisateurs'));
    }
    
    function page_detail_util($id)
    {
        if (User::find($id)){

            $utilisateur = DB::Table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->leftJoin('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->leftJoin('genres', 'utilisateurs.code_genre', '=', 'genres.code')
                ->leftJoin('equipes', 'utilisateurs.id_equipe', '=', 'equipes.id')
                ->leftJoin('colleges', 'utilisateurs.id_college', '=', 'colleges.id')
                ->leftJoin('roles', 'engager.id_role', '=', 'roles.id')
                ->where('users.id', '=', $id)
                ->select('users.*',
                        'utilisateurs.*',
                        'utilisateurs.commentaire as commentaire_util',
                        'equipes.nom as equipe',
                        'colleges.nom as college',
                        'roles.nom as role',
                        'genres.nom as genre',
                        'engager.*')
                ->first();

                $view = view('administrateur.detail_util_admin', compact('utilisateur'));
        }
        else{
            $view = redirect()->route('administrateur.affichage_utils') 
                ->with('Erreur', 'L\'utilisateur n\'existe pas'); //Ajouter un message d'erreur 
        }
        return $view;
    }


    function page_modif_util($id)
    {
        if (User::find($id)){

            $utilisateur = DB::Table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->leftJoin('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->leftJoin('genres', 'utilisateurs.code_genre', '=', 'genres.code')
                ->leftJoin('equipes', 'utilisateurs.id_equipe', '=', 'equipes.id')
                ->leftJoin('colleges', 'utilisateurs.id_college', '=', 'colleges.id')
                ->leftJoin('roles', 'engager.id_role', '=', 'roles.id')
                ->leftJoin('concours', 'engager.id_concourS', '=', 'concours.id')
                ->where('users.id', '=', $id)
                ->select('users.*',
                        'utilisateurs.*',
                        'utilisateurs.commentaire as commentaire_util',
                        'equipes.nom as nom_equipe',
                        'equipes.id as id_equipe',
                        'colleges.id as id_college', 
                        'colleges.nom as nom_college',
                        'roles.id as id_role',
                        'roles.nom as nom_role',
                        'concours.id as id_concour',
                        'genres.code as code_genre',
                        'genres.nom as nom_genre'
                        )
                ->first();

                $les_concours = Concour::all();
                $les_roles = Role::all();
                $les_colleges = College::all();
                $les_equipes = Equipe::all();
                $les_genres = Genre::all();

                $view = view('administrateur.modification_util_admin', compact('utilisateur', 'les_roles', 'les_colleges', 
                                                                        'les_equipes', 'les_genres', 'les_concours'));
        }
        else{
            $view = redirect()->route('administrateur.affichage_utils') 
                ->with('Erreur', 'L\'utilisateur n\'existe pas'); //Ajouter un message d'erreur 
        }
        return $view;
    }

    function page_creation_util()
    {
        //Retourne un objet contenant tout les rôles
        $genres = Genre::all();
        $roles = Role::all();
        $concours = Concour::all();
        return view('administrateur.creation_util_admin', compact('roles', 'genres', 'concours'));
    }

##
##  Fonctions CRUD 
##

    //Géneration d'utilisateur 
    function ajouter_util(Request $request)
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

        if (Role::find($validerUser['role']) && Genre::find($validerUser['genre']) && Concour::find($validerUser['concour'])){
            //Seulement utilsier les 3 premières lettres d'un prénom (sauf si le prénom est inférieur à 2 lettres de longeur)
            $nameUser = RequeteSupport::generationNom($validerUser['name'], $validerUser['prenom']);

           $user = User::create([
                'name' => $nameUser,
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
            
            return redirect()->route('administrateur.creation_util')
                ->with('success', 'Utilisateur créé et email envoyé');
        }
    }

    function supprimer_util($id)
    {
        if(User::find($id)){

            DB::table('scorer')->where('id_secretaire', '=', $id)->delete();
            DB::table('engager')->where('id_utilisateur', '=', $id)->delete();
            DB::table('utilisateurs')->where('id', '=', $id)->delete();
            DB::table('users')->where('id', '=', $id)->delete();
            
            $view = redirect()->route('administrateur.affichage_utils')
            ->with('success', 'Utilisateur supprimer');
        }
        else {
            $view = redirect()->route('administrateur.affichage_utils')
            ->with('Erreur', 'L\'utilisateur n\'a pas été supprimer');
        }
            
        return $view;
    }

    function modification_util(Request $request, $idUtil)
    {
              //  dd($request->all());
        $validerUser = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($idUtil)],
            'motdepasse' => ['string'],
            'role' => ['required', 'integer'],
            'genre' => ['required', 'string', 'max:1'],
            'college' => ['integer'],
            'commentaire' => ['string', 'max:1024'],
            'concour' => ['required', 'integer']
        ]);

        if(User::find($idUtil)){
            $name = RequeteSupport::generationNom($validerUser['nom'], $validerUser['prenom']);
            $informationsUser = [
                "name" => $name,
                "email" => $validerUser['email']
            ];

            if($validerUser['motdepasse'] == "on"){

                $motdepasseEnClaire = Str::random(16);
                $motdepasseHash = Hash::make($motdepasseEnClaire);
                
                $informationsUser['password'] = $motdepasseHash;

                Mail::to($validerUser['email'])->send(new ModificationUtil($validerUser['email'], $motdepasseEnClaire));
            }

            DB::table('users')->where('id', $idUtil)
                ->update($informationsUser);


            DB::table('utilisateurs')->where('id', $idUtil)
                ->update([
                    'nom' => $validerUser['nom'], 
                    'prenom' => $validerUser['prenom'],
                    'commentaire' => $validerUser['commentaire'],
                    'code_genre' => $validerUser['genre'],
                    'id_college' => $validerUser['college'],
                ]);
                
            DB::table('engager')->where('id_utilisateur', $idUtil)
                ->update([
                    'id_concours' => $validerUser['concour'],
                    'id_role' => $validerUser['role']
                ]);              
        }
        else {
        return redirect()->route('administrateur.affichage_utils')
        ->with('Erreur', 'L\'utilisateur n\'existe pas');
        }
    }
}