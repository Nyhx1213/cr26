<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Equipe;
use App\Models\Participer;
use App\Models\Pay;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class College
 * 
 * @property int $id
 * @property string|null $code
 * @property string $nom
 * @property string|null $adr_ligne_1
 * @property string|null $adr_ligne_2
 * @property string|null $adr_lieu
 * @property string|null $adr_code_postal
 * @property string|null $adr_ville
 * @property string|null $adr_region
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $code_pays
 * 
 * @property Pay $pay
 * @property Collection|Equipe[] $equipes
 * @property Collection|Participer[] $participers
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models\Base
 */
class College extends Model
{
	protected $table = 'colleges';

	public function pay()
	{
		return $this->belongsTo(Pay::class, 'code_pays');
	}

	public function equipes()
	{
		return $this->hasMany(Equipe::class, 'id_college');
	}

	public function participers()
	{
		return $this->hasMany(Participer::class, 'id_college');
	}

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'id_college');
	}
}
