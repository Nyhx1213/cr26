<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Concour;
use App\Models\Role;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Engager
 * 
 * @property int $id_utilisateur
 * @property int $id_concours
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_role
 * 
 * @property Utilisateur $utilisateur
 * @property Concour $concour
 * @property Role $role
 *
 * @package App\Models\Base
 */
class Engager extends Model
{
	protected $table = 'engager';
	public $incrementing = false;

	protected $casts = [
		'id_utilisateur' => 'int',
		'id_concours' => 'int',
		'id_role' => 'int'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}

	public function concour()
	{
		return $this->belongsTo(Concour::class, 'id_concours');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'id_role');
	}
}
