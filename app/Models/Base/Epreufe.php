<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Category;
use App\Models\Concour;
use App\Models\Scorer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Epreufe
 * 
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property float $score_max
 * @property float $coefficient
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_concours
 * @property int $id_categorie
 * 
 * @property Concour $concour
 * @property Category $category
 * @property Collection|Scorer[] $scorers
 *
 * @package App\Models\Base
 */
class Epreufe extends Model
{
	protected $table = 'epreuves';

	protected $casts = [
		'score_max' => 'float',
		'coefficient' => 'float',
		'id_concours' => 'int',
		'id_categorie' => 'int'
	];

	public function concour()
	{
		return $this->belongsTo(Concour::class, 'id_concours');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'id_categorie');
	}

	public function scorers()
	{
		return $this->hasMany(Scorer::class, 'id_epreuve');
	}
}
