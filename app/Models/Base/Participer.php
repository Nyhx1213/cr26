<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\College;
use App\Models\Concour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Participer
 * 
 * @property int $id_college
 * @property int $id_concours
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property College $college
 * @property Concour $concour
 *
 * @package App\Models\Base
 */
class Participer extends Model
{
	protected $table = 'participer';
	public $incrementing = false;

	protected $casts = [
		'id_college' => 'int',
		'id_concours' => 'int'
	];

	public function college()
	{
		return $this->belongsTo(College::class, 'id_college');
	}

	public function concour()
	{
		return $this->belongsTo(Concour::class, 'id_concours');
	}
}
