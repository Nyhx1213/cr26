<?php
namespace App\Requetes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ModificationUtil;

class RequeteSupport 
{

    public static function generationNom(string $nom, string $prenom)
    {
        if (strlen($prenom)  >= 3){
            $nameUser = $prenom[0].$prenom[1].$prenom[2].$nom;
        }
        else{
            $nameUser = $prenom.".".$nom;
        }
        return $nameUser;
    }

    public static function updateUtil(int $idUtil, array $validerUser)
    {
        $name = self::generationNom($validerUser['nom'], $validerUser['prenom']);
        
        if($validerUser['motdepasse'] == true) 
            {
                $motdepasseEnClaire = Str::random(16);
                $motdepasseHash = Hash::make($motdepasseEnClaire);

                DB::table('users')->where('id', $idUtil)      
                    ->update([
                        'password' => $motdepasseHash
                    ]);
                Mail::to($validerUser['email'])->send(new ModificationUtil($validerUser['email'], $motdepasseEnClaire));

            }

            DB::table('users')->where('id', $idUtil)
                ->update([
                    'name' => $name , 
                    'email' => $validerUser['email']
                ]);


            DB::table('utilisateurs')->where('id', $idUtil)
                ->update([
                    'nom' => $validerUser['nom'], 
                    'prenom' => $validerUser['prenom'],
                    'commentaire' => $validerUser['commentaire'],
                    'code_genre' => $validerUser['genre'],
                    'id_college' => $validerUser['college'],
                    'id_equipe' => $validerUser['equipe']
                ]);
                
            DB::table('engager')->where('id_utilisateur', $idUtil)
                ->update([
                    'id_concours' => $validerUser['id_concour'],
                    'id_role' => $validerUser['id_role']
                ]);                
    }
}
