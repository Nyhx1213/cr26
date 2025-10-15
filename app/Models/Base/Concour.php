<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Category;
use App\Models\Engager;
use App\Models\Epreufe;
use App\Models\Equipe;
use App\Models\Participer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Concour
 * 
 * @property int $id
 * @property string $nom
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property bool $actif
 * @property bool $en_cours
 * @property int $equipe_min
 * @property int $equipe_max
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Category[] $categories
 * @property Collection|Engager[] $engagers
 * @property Collection|Epreufe[] $epreuves
 * @property Collection|Equipe[] $equipes
 * @property Collection|Participer[] $participers
 *
 * @package App\Models\Base
 */
class Concour extends Model
{
	protected $table = 'concours';

	protected $casts = [
		'date_debut' => 'datetime',
		'date_fin' => 'datetime',
		'actif' => 'bool',
		'en_cours' => 'bool',
		'equipe_min' => 'int',
		'equipe_max' => 'int'
	];

	public function categories()
	{
		return $this->hasMany(Category::class, 'id_concours');
	}

	public function engagers()
	{
		return $this->hasMany(Engager::class, 'id_concours');
	}

	public function epreuves()
	{
		return $this->hasMany(Epreufe::class, 'id_concours');
	}

	public function equipes()
	{
		return $this->hasMany(Equipe::class, 'id_concours');
	}

	public function participers()
	{
		return $this->hasMany(Participer::class, 'id_concours');
	}
}
