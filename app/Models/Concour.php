<?php

namespace App\Models;

use App\Models\Base\Concour as BaseConcour;

class Concour extends BaseConcour
{
	protected $fillable = [
		'nom',
		'date_debut',
		'date_fin',
		'actif',
		'en_cours',
		'commentaire'
	];
}
