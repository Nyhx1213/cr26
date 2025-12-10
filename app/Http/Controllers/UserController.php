<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Concour;
use App\Models\User;
use App\Models\College;
use App\Models\Statut;
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
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
    function listeUtilisateurs()
    {
       $les_utilisateurs = User::listeUtilisateurs();

        return view('administrateur.listeUtilisateurs', compact('les_utilisateurs'));
    }
    
    /**
     * Affiche les détails d’un utilisateur précis.
     * 
     * Rejoint plusieurs tables liées à l’utilisateur pour afficher
     * ses informations complètes (genre, équipe, collège, rôle, etc.).
     */
    function detailUtilisateur($id)
    {
        if (User::find($id)){

            $utilisateur = User::detailUtilisateur($id);

            $view = view('administrateur.detailUtilisateur', compact('utilisateur'));
        }
        else {
            // Si l'utilisateur n'existe pas → redirection avec message d'erreur
            Log::error('Utilisateur pas trouvé', ['userID' => $id ?? null]);

            $view = redirect()->route('error') 
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
    function formulaireModificationUtil($id)
    { 
        if (User::find($id)){

            $utilisateur = User::formulaireModification($id);
    
            // Chargement des listes pour le formulaire
            $les_concours = Concour::all();
            $les_roles = Role::all();
            $les_colleges = College::all();
            $les_equipes = Equipe::all();
            $les_genres = Genre::all();
            $les_statuts = Statut::all();

            $view = view('administrateur.modificationUtilisateur', compact(
                'utilisateur', 'les_roles', 'les_colleges', 
                'les_equipes', 'les_genres', 'les_concours', 'les_statuts'
            ));
        }
        else {
            Log::error('Utilisateur pas trouvé', ['userID' => $id ?? null]);
            $view = redirect()->route('error') 
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
    function formulaireGeneration()
    {
        $genres = Genre::all();
        $roles = Role::all();
        $concours = Concour::all();
        $colleges = College::all();
        $statuts = Statut::all();
        return view('administrateur.generationUtilisateur', compact('roles', 'genres', 'concours', 'colleges', 'statuts'));
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
    function ajouterUtilisateur(Request $request)
    {
        // Validation des champs du formulaire
        $validerUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'role' => ['required', 'integer'],
            'prenom' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:1'],
            'concour' => ['required', 'integer'],
            'college' => ['nullable', 'integer'],
            'statut' => ['required', 'string', 'max:2'],
        ]);

        // Génération d’un mot de passe aléatoire (en clair pour l'instant)
        $motdepasseEnClaire = Str::random(16);
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
                try {
                    event(new Registered($user)); // Verification de mail
                } catch (TransportExceptionInterface $e) {
                    // Message d'erreur a l'utilisateur 
                    return back()->withErrors([
                    'email' => 'L\'addresse mail n\'a pas été trouvez.'
                ]);
            }
            
            // Création du profil utilisateur
            Utilisateur::create([
                'id' => $user->id,
                'nom' => $validerUser['name'],
                'prenom' => $validerUser['prenom'],
                'code_statut' => $validerUser['statut'],
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
            
            $view = redirect()->route('administrateur.generation-utilisateur')
                ->with('success', 'Utilisateur créé et email envoyé');
        }
        else {
            Log::error('Erreur pendant création d\'utilisateur');
            $view = redirect()->route('error')
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
    function suppressionUtilisateur($id)
    {
        if(User::find($id)){
            // Transaction : si une suppression échoue, tout est annulé
            User::supprimerUtil($id);

            $view = redirect()->route('administrateur.liste-utilisateurs')
                ->with('success', 'Utilisateur supprimé');
        }
        else {
            Log::error('Erreur pendant supression d\'utilisateur', ['userID' => $id ?? null]);
            $view = redirect()->route('error')
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
    function modificationUtilisateur(Request $request, $idUtil)
    {   
        $validerUser = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($idUtil)],
            'motdepasse' => ['string', 'nullable'],
            'role' => ['required', 'integer'],
            'genre' => ['required', 'string', 'max:1'],
            'college' => ['integer', 'nullable'],
            'commentaire' => ['string', 'nullable', 'max:1024'],
            'concour' => ['required', 'integer'],
            'statut' => ['required', 'string', 'max:2']
        ]);


        if(User::find($idUtil) && Role::find($validerUser['role'])){
            $name = RequeteSupport::generationNom($validerUser['nom'], $validerUser['prenom']);

            // Informations de base du compte User
            $informationsUser = [
                "name" => $name,
                "email" => $validerUser['email']
            ];

            // Si le mot de passe doit être régénéré
            if(isset($validerUser['motdepasse']) && $validerUser['motdepasse'] == "on"){
                $motdepasseEnClaire = Str::random(16);
                $motdepasseHash = Hash::make($motdepasseEnClaire);
                $informationsUser['password'] = $motdepasseHash;

             try {
                Mail::to($validerUser['email'])->send(new ModificationUtil($validerUser['email'], $motdepasseEnClaire));
            } catch (TransportExceptionInterface $e) {
                return back()->withErrors([
                    'email' => 'L\'addresse mail n\'a pas été trouvez.'
                ]);
            }
            }

            // Pas conforme RGPD a modifier avec une rénisialisation de mot de passe avec un durée longue plus tard !!


            // Mise à jour des tables

            $user = User::updateUtil($validerUser, $idUtil, $informationsUser);
            
            $view = redirect()->route('administrateur.detail-utilisateur', $idUtil)
                ->with('Success', 'L\'utilisateur a été modifié');
        }
        else {
            Log::error('Erreur pendant modification d\'utilisateur', ['userID' => $id ?? null]);
            $view = redirect()->route('error')
                ->with('Erreur', 'L\'utilisateur n\'existe pas');
        }
        return $view;
    }
}
 
