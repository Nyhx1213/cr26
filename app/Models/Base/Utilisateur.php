<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\College;
use App\Models\Engager;
use App\Models\Equipe;
use App\Models\Genre;
use App\Models\Scorer;
use App\Models\Statut;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Utilisateur
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string|null $classe
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $code_statut
 * @property string $code_genre
 * @property int|null $id_college
 * @property int|null $id_equipe
 * 
 * @property User $user
 * @property Statut $statut
 * @property Genre $genre
 * @property College|null $college
 * @property Equipe|null $equipe
 * @property Collection|Engager[] $engagers
 * @property Collection|Scorer[] $scorers
 *
 * @package App\Models\Base
 */
class Utilisateur extends Model
{
	protected $table = 'utilisateurs';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'id_college' => 'int',
		'id_equipe' => 'int'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id');
	}

	public function statut()
	{
		return $this->belongsTo(Statut::class, 'code_statut');
	}

	public function genre()
	{
		return $this->belongsTo(Genre::class, 'code_genre');
	}

	public function college()
	{
		return $this->belongsTo(College::class, 'id_college');
	}

	public function equipe()
	{
		return $this->belongsTo(Equipe::class, 'id_equipe');
	}

	public function engagers()
	{
		return $this->hasMany(Engager::class, 'id_utilisateur');
	}

	public function scorers()
	{
		return $this->hasMany(Scorer::class, 'id_secretaire');
	}
}
