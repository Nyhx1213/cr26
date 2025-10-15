<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Classer;
use App\Models\College;
use App\Models\Concour;
use App\Models\Scorer;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipe
 * 
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property string|null $site
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_concours
 * @property int $id_college
 * 
 * @property Concour $concour
 * @property College $college
 * @property Collection|Classer[] $classers
 * @property Collection|Scorer[] $scorers
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models\Base
 */
class Equipe extends Model
{
	protected $table = 'equipes';

	protected $casts = [
		'id_concours' => 'int',
		'id_college' => 'int'
	];

	public function concour()
	{
		return $this->belongsTo(Concour::class, 'id_concours');
	}

	public function college()
	{
		return $this->belongsTo(College::class, 'id_college');
	}

	public function classers()
	{
		return $this->hasMany(Classer::class, 'id_equipe');
	}

	public function scorers()
	{
		return $this->hasMany(Scorer::class, 'id_equipe');
	}

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'id_equipe');
	}
}
