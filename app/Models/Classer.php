<?php

namespace App\Models;

use App\Models\Base\Classer as BaseClasser;

class Classer extends BaseClasser
{
	protected $fillable = [
		'commentaire',
		'score_total'
	];
}
