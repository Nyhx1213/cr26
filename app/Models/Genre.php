<?php

namespace App\Models;

use App\Models\Base\Genre as BaseGenre;

class Genre extends BaseGenre
{
	protected $fillable = [
		'nom',
		'commentaire'
	];
}
