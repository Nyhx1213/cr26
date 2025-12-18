<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function detailUtilisateur($id)
    {
        return DB::table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->leftJoin('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->leftJoin('genres', 'utilisateurs.code_genre', '=', 'genres.code')
                ->leftJoin('equipes', 'utilisateurs.id_equipe', '=', 'equipes.id')
                ->leftJoin('colleges', 'utilisateurs.id_college', '=', 'colleges.id')
                ->leftJoin('roles', 'engager.id_role', '=', 'roles.id')
                ->leftJoin('statuts', 'utilisateurs.code_statut', '=' , 'statuts.code')
                ->where('users.id', '=', $id)
                ->select(
                    'users.*',
                    'statuts.nom as nom_statut',
                    'statuts.code as code_statut',
                    'utilisateurs.*',
                    'utilisateurs.commentaire as commentaire_util',
                    'equipes.nom as equipe',
                    'colleges.nom as college',
                    'roles.nom as role',
                    'genres.nom as genre',
                    'engager.*'
                )
                ->first();
    }

    public static function listeUtilisateurs()
    {
        return  DB::table('users')
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
                    ->paginate(10);
    }
    
    public static function utilisateursBymail($email){
        return  DB::table('users')
                    ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                    ->join('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                    ->join('roles', 'engager.id_role', '=', 'roles.id')
                    ->where('users.email', 'LIKE', '%'.$email.'%')
                    ->select(
                        'users.*',
                        'utilisateurs.*',
                        'engager.*',
                        'roles.nom as role'
                    )    
                    ->orderBy('users.id')
                    ->paginate(10);
    }

        public static function utilisateurByRole($role){
        return  DB::table('users')
                    ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                    ->join('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                    ->join('roles', 'engager.id_role', '=', 'roles.id')
                    ->where('roles.id', '=', $role)
                    ->select(
                        'users.*',
                        'utilisateurs.*',
                        'engager.*',
                        'roles.nom as role'
                    )    
                    ->orderBy('users.id')
                    ->paginate(10);
    }
    public static function deleteMultiple($ids){

    DB::table('scorer')->whereIn('id_secretaire', $ids)->delete();
    DB::table('engager')->whereIn('id_utilisateur', $ids)->delete();
    DB::table('utilisateurs')->whereIn('id', $ids)->delete();
    DB::table('users')->whereIn('id', $ids)->delete();

    }

        public static function utilisateursByRoleMail($role, $email){
            return DB::table('users')
                ->join('utilisateurs', 'users.id', '=', 'utilisateurs.id')
                ->join('engager','utilisateurs.id', '=', 'engager.id_utilisateur')
                ->join('roles', 'engager.id_role', '=', 'roles.id')
                ->where('roles.id', '=', $role)
                ->where('users.email', 'LIKE', '%'.$email.'%')
                ->select(
                    'users.*',
                    'utilisateurs.*',
                    'engager.*',
                    'roles.nom as role'
                )
                ->orderBy('users.id')
                ->paginate(10);

    }
    
    
    public static function formulaireModification($id)
    {
          
            return DB::table('users')
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

    }

    public static function supprimerUtil($id)
    {
        return DB::transaction(function() use ($id) {
                DB::table('scorer')->where('id_secretaire', '=', $id)->delete();
                DB::table('engager')->where('id_utilisateur', '=', $id)->delete();
                DB::table('utilisateurs')->where('id', '=', $id)->delete();
                DB::table('users')->where('id', '=', $id)->delete();
            });
    }

    public static function updateUtil($validerUser, $idUtil, $informationsUser)
    {
            DB::table('users')->where('id', $idUtil)
                ->update($informationsUser);

            DB::table('utilisateurs')->where('id', $idUtil)
                ->update([
                    'nom' => $validerUser['nom'], 
                    'prenom' => $validerUser['prenom'],
                    'commentaire' => $validerUser['commentaire'],
                    'code_genre' => $validerUser['genre'],
                    'id_college' => $validerUser['college'],
                    'code_statut' => $validerUser['statut']
                ]);
                
            DB::table('engager')->where('id_utilisateur', $idUtil)
                ->update([
                    'id_concours' => $validerUser['concour'],
                    'id_role' => $validerUser['role']
                ]);

    }
}
