<?php

namespace App\Models;

use App\Models\Base\Utilisateur as BaseUtilisateur;

class Utilisateur extends BaseUtilisateur
{
	protected $fillable = [
		'id',
		'nom',
		'prenom',
		'classe',
		'commentaire',
		'code_genre',
		'id_college',
		'code_statut',
		'id_equipe',
		'id_role'
	];
}
