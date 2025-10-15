<?php

namespace App\Models;

use App\Models\Base\Utilisateur as BaseUtilisateur;

class Utilisateur extends BaseUtilisateur
{
	protected $fillable = [
		'nom',
		'prenom',
		'classe',
		'commentaire',
		'code_genre',
		'id_college',
		'id_equipe',
		'id_role'
	];
}
