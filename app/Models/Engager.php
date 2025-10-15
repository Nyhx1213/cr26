<?php

namespace App\Models;

use App\Models\Base\Engager as BaseEngager;

class Engager extends BaseEngager
{
	protected $fillable = [
		'commentaire',
		'id_role'
	];
}
