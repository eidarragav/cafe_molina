<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Measure
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $measure_type
 * 
 * @property Collection|MaquilaPackage[] $maquila_packages
 *
 * @package App\Models
 */
class Measure extends Model
{
	protected $table = 'measures';

	protected $fillable = [
		'measure_type'
	];

	public function maquila_packages()
	{
		return $this->hasMany(MaquilaPackage::class);
	}
}
