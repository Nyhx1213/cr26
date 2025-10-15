<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Epreufe;
use App\Models\Equipe;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Scorer
 * 
 * @property int $id_secretaire
 * @property int $id_equipe
 * @property int $id_epreuve
 * @property float $score
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Utilisateur $utilisateur
 * @property Equipe $equipe
 * @property Epreufe $epreufe
 *
 * @package App\Models\Base
 */
class Scorer extends Model
{
	protected $table = 'scorer';
	public $incrementing = false;

	protected $casts = [
		'id_secretaire' => 'int',
		'id_equipe' => 'int',
		'id_epreuve' => 'int',
		'score' => 'float'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_secretaire');
	}

	public function equipe()
	{
		return $this->belongsTo(Equipe::class, 'id_equipe');
	}

	public function epreufe()
	{
		return $this->belongsTo(Epreufe::class, 'id_epreuve');
	}
}
