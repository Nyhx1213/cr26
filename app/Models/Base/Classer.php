<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Category;
use App\Models\Equipe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classer
 * 
 * @property int $id_equipe
 * @property int $id_categorie
 * @property float $score_total
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Equipe $equipe
 * @property Category $category
 *
 * @package App\Models\Base
 */
class Classer extends Model
{
	protected $table = 'classer';
	public $incrementing = false;

	protected $casts = [
		'id_equipe' => 'int',
		'id_categorie' => 'int',
		'score_total' => 'float'
	];

	public function equipe()
	{
		return $this->belongsTo(Equipe::class, 'id_equipe');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'id_categorie');
	}
}
