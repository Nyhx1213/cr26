<?php

namespace App\Models;

use App\Models\Base\Equipe as BaseEquipe;

class Equipe extends BaseEquipe
{
	protected $fillable = [
		'code',
		'nom',
		'site',
		'commentaire',
		'id_college'
	];
}
