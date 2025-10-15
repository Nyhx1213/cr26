<?php

namespace App\Models;

use App\Models\Base\Epreufe as BaseEpreufe;

class Epreufe extends BaseEpreufe
{
	protected $fillable = [
		'code',
		'nom',
		'score_max',
		'coefficient',
		'commentaire',
		'id_concours',
		'id_categorie'
	];
}
