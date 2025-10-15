<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Engager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string|null $code
 * @property string $nom
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Engager[] $engagers
 *
 * @package App\Models\Base
 */
class Role extends Model
{
	protected $table = 'roles';

	public function engagers()
	{
		return $this->hasMany(Engager::class, 'id_role');
	}

}
