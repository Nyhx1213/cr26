<?php

namespace App\Models;

use App\Models\Base\College as BaseCollege;

class College extends BaseCollege
{
	protected $fillable = [
		'code',
		'nom',
		'adr_ligne_1',
		'adr_ligne_2',
		'adr_lieu',
		'adr_code_postal',
		'adr_ville',
		'adr_region',
		'commentaire',
		'code_pays'
	];
}
