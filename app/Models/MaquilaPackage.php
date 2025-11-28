<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaquilaPackage
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $maquila_order_id
 * @property int $measure_id
 * @property string $kilograms
 * 
 * @property MaquilaOrder $maquila_order
 * @property Measure $measure
 *
 * @package App\Models
 */
class MaquilaPackage extends Model
{
	protected $table = 'maquila_packages';

	protected $casts = [
		'maquila_order_id' => 'int',
		'measure_id' => 'int'
	];

	protected $fillable = [
		'maquila_order_id',
		'package_id',
		'mesh',
		'kilograms',
		'presentation'
	];


	public function maquila_order()
	{
		return $this->belongsTo(MaquilaOrder::class);
	}

	public function measure()
	{
		return $this->belongsTo(Measure::class);
	}

	public function package()
	{
		return $this->belongsTo(Package::class);
	}
}
