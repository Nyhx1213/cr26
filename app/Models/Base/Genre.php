<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 * 
 * @property string $code
 * @property string $nom
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models\Base
 */
class Genre extends Model
{
	protected $table = 'genres';
	protected $primaryKey = 'code';
	public $incrementing = false;

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'code_genre');
	}
}
