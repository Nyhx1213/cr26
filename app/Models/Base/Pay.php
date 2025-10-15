<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\College;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pay
 * 
 * @property string $code
 * @property string $nom
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|College[] $colleges
 *
 * @package App\Models\Base
 */
class Pay extends Model
{
	protected $table = 'pays';
	protected $primaryKey = 'code';
	public $incrementing = false;

	public function colleges()
	{
		return $this->hasMany(College::class, 'code_pays');
	}
}
