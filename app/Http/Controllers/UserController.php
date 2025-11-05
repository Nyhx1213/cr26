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

class UserController extends Controller
{

    ##
    ##     AFFICHAGE DES PAGES UTILISATEURS
    ##

    /**
     * Affiche la liste paginée des utilisateurs avec leur rôle.
     * 
     * Rejoint les tables :
     * - users : informations de connexion
     * - utilisateurs : informations personnelles
     * - engager : lien entre utilisateur et rôle
     * - roles : nom du rôle
     */
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
                'roles.nom as role'
            )    
            ->orderBy('users.id')
            ->paginate(30);

        return view('administrateur.affichage_util_admin', compact('les_utilisateurs'));
    }
    
    /**
     * Affiche les détails d’un utilisateur précis.
     * 
     * Rejoint plusieurs tables liées à l’utilisateur pour afficher
     * ses informations complètes (genre, équipe, collège, rôle, etc.).
     */
    function page_detail_util($id)
    {
        if (User::find($id)){

            $utilisateur = DB::table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->leftJoin('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->leftJoin('genres', 'utilisateurs.code_genre', '=', 'genres.code')
                ->leftJoin('equipes', 'utilisateurs.id_equipe', '=', 'equipes.id')
                ->leftJoin('colleges', 'utilisateurs.id_college', '=', 'colleges.id')
                ->leftJoin('roles', 'engager.id_role', '=', 'roles.id')
                ->where('users.id', '=', $id)
                ->select(
                    'users.*',
                    'utilisateurs.*',
                    'utilisateurs.commentaire as commentaire_util',
                    'equipes.nom as equipe',
                    'colleges.nom as college',
                    'roles.nom as role',
                    'genres.nom as genre',
                    'engager.*'
                )
                ->first();

            $view = view('administrateur.detail_util_admin', compact('utilisateur'));
        }
        else {
            // Si l'utilisateur n'existe pas → redirection avec message d'erreur
            $view = redirect()->route('administrateur.affichage_utils') 
                ->with('Erreur', 'L\'utilisateur n\'existe pas');
        }
        return $view;
    }

    /**
     * Affiche la page de modification d’un utilisateur.
     * 
     * Charge également les collections nécessaires pour les menus déroulants
     * (rôles, concours, collèges, équipes, genres...).
     */
    function page_modif_util($id)
    { 
        if (User::find($id)){

            $utilisateur = DB::table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->leftJoin('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->leftJoin('genres', 'utilisateurs.code_genre', '=', 'genres.code')
                ->leftJoin('equipes', 'utilisateurs.id_equipe', '=', 'equipes.id')
                ->leftJoin('colleges', 'utilisateurs.id_college', '=', 'colleges.id')
                ->leftJoin('roles', 'engager.id_role', '=', 'roles.id')
                ->leftJoin('concours', 'engager.id_concourS', '=', 'concours.id')
                ->where('users.id', '=', $id)
                ->select(
                    'users.*',
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

            // Chargement des listes pour le formulaire
            $les_concours = Concour::all();
            $les_roles = Role::all();
            $les_colleges = College::all();
            $les_equipes = Equipe::all();
            $les_genres = Genre::all();

            $view = view('administrateur.modification_util_admin', compact(
                'utilisateur', 'les_roles', 'les_colleges', 
                'les_equipes', 'les_genres', 'les_concours'
            ));
        }
        else {
            $view = redirect()->route('administrateur.affichage_utils') 
                ->with('Erreur', 'L\'utilisateur n\'existe pas');
        }
        return $view;
    }

    /**
     * Affiche la page de création d’un nouvel utilisateur.
     * 
     * Passe les listes de rôles, genres, concours et collèges
     * au formulaire pour les menus déroulants.
     */
    function page_creation_util()
    {
        $genres = Genre::all();
        $roles = Role::all();
        $concours = Concour::all();
        $colleges = College::all();
        return view('administrateur.creation_util_admin', compact('roles', 'genres', 'concours', 'colleges'));
    }

    ##
    ###  FONCTIONS CRUD
    ##

    /**
     * Crée un nouvel utilisateur.
     * 
     * - Valide les champs requis.
     * - Génère un mot de passe aléatoire.
     * - Crée les entrées dans les tables users, utilisateurs et engager.
     * - Envoie un e-mail (actuellement désactivé).
     */
    function ajouter_util(Request $request)
    {
        // Validation des champs du formulaire
        $validerUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'role' => ['required', 'integer'],
            'prenom' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:1'],
            'concour' => ['required', 'integer']
        ]);

        // Génération d’un mot de passe aléatoire (en clair pour l'instant)
        $motdepasseEnClaire = Str::random(16);
        //$request['password'] = $motdepasseEnClaire;
        //$validerUser['password'] = Hash::make($request['password']);
        $validerUser['password'] = Hash::make($motdepasseEnClaire);


        // Vérifie la cohérence des ID référencés
        if (Role::find($validerUser['role']) && Genre::find($validerUser['genre']) && Concour::find($validerUser['concour'])) {
            
            // Génération du nom d’utilisateur (ex: DupJUL)
            $nameUser = RequeteSupport::generationNom($validerUser['name'], $validerUser['prenom']);

            // Création du compte principal
            $user = User::create([
                'name' => $nameUser,
                'email' => $validerUser['email'],
                'password' => $validerUser['password']
            ]);
            
            // Événement Laravel (ex: vérification d'email)
                event(new Registered($user));
            
            // Création du profil utilisateur
            Utilisateur::create([
                'id' => $user->id,
                'nom' => $validerUser['name'],
                'prenom' => $validerUser['prenom'],
                'code_statut' => 'N',
                'code_genre' => $validerUser['genre']
            ]);

            // Création du lien vers son rôle et concours
            Engager::create([
                'id_utilisateur' => $user->id,
                'id_role' => $validerUser['role'],
                'id_concours' => $validerUser['concour']
            ]);

            // Envoi de mail désactivé, à remplacer par un lien de réinitialisation
            // Mail::to($user->email)->send(new MailInfoUtil($user, $motdepasseEnClaire));
            
            $view = redirect()->route('administrateur.creation_util')
                ->with('success', 'Utilisateur créé et email envoyé');
        }
        else {
            $view = redirect()->route('administrateur.creation_util')
                ->with('error', 'Une erreur est survenue, veuillez contacter un administrateur.');
        }
        return $view;
    }

    /**
     * Supprime un utilisateur (et ses dépendances) via une transaction.
     * 
     * Supprime les données associées dans les tables :
     * - scorer
     * - engager
     * - utilisateurs
     * - users
     */
    function supprimer_util($id)
    {
        if(User::find($id)){
            // Transaction : si une suppression échoue, tout est annulé
            DB::transaction(function() use ($id) {
                DB::table('scorer')->where('id_secretaire', '=', $id)->delete();
                DB::table('engager')->where('id_utilisateur', '=', $id)->delete();
                DB::table('utilisateurs')->where('id', '=', $id)->delete();
                DB::table('users')->where('id', '=', $id)->delete();
            });
            
            $view = redirect()->route('administrateur.affichage_utils')
                ->with('success', 'Utilisateur supprimé');
        }
        else {
            $view = redirect()->route('administrateur.affichage_utils')
                ->with('Erreur', 'L\'utilisateur n\'a pas été supprimé');
        }
        return $view;
    }

    /**
     * Met à jour les informations d’un utilisateur existant.
     * 
     * - Met à jour les données dans les trois tables principales.
     * - Si "motdepasse" = "on", régénère un mot de passe et le met à jour.
     */
    function modification_util(Request $request, $idUtil)
    {        
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
        
        // Si le champ motdepasse n'est pas coché
        if (!$validerUser['motdepasse']){
            $validerUser['motdepasse'] = "off";
        }

        if(User::find($idUtil)){
            $name = RequeteSupport::generationNom($validerUser['nom'], $validerUser['prenom']);

            // Informations de base du compte User
            $informationsUser = [
                "name" => $name,
                "email" => $validerUser['email']
            ];

            // Si le mot de passe doit être régénéré
            if($validerUser['motdepasse'] == "on"){
                $motdepasseEnClaire = Str::random(16);
                $motdepasseHash = Hash::make($motdepasseEnClaire);
                $informationsUser['password'] = $motdepasseHash;

                // Envoi de mail désactivé (mieux : lien de réinitialisation)
                // Mail::to($validerUser['email'])->send(new ModificationUtil($validerUser['email'], $motdepasseEnClaire));
            }

            // Mise à jour des tables
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

            $view = redirect()->route('administrateur.affichage_utils')
                ->with('Success', 'L\'utilisateur a été modifié');
        }
        else {
            $view = redirect()->route('administrateur.affichage_utils')
                ->with('Erreur', 'L\'utilisateur n\'existe pas');
        }
        return $view;
    }
}
