<?php

namespace App\Models;

use App\Models\Base\Pay as BasePay;

class Pay extends BasePay
{
	protected $fillable = [
		'nom',
		'commentaire'
	];
}
