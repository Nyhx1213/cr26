<?php

namespace App\Models;

use App\Models\Base\Statut as BaseStatut;

class Statut extends BaseStatut
{
	protected $fillable = [
		'nom',
		'commentaire'
	];
}
