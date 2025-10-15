<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Classer;
use App\Models\Concour;
use App\Models\Epreufe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_concours
 * 
 * @property Concour $concour
 * @property Collection|Classer[] $classers
 * @property Collection|Epreufe[] $epreuves
 *
 * @package App\Models\Base
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'id_concours' => 'int'
	];

	public function concour()
	{
		return $this->belongsTo(Concour::class, 'id_concours');
	}

	public function classers()
	{
		return $this->hasMany(Classer::class, 'id_categorie');
	}

	public function epreuves()
	{
		return $this->hasMany(Epreufe::class, 'id_categorie');
	}
}
