<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaquilaService
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $service_id
 * @property int $maquila_order_id
 * 
 * @property MaquilaOrder $maquila_order
 * @property Service $service
 *
 * @package App\Models
 */
class MaquilaService extends Model
{
	protected $table = 'maquila_services';

	protected $casts = [
		'service_id' => 'int',
		'maquila_order_id' => 'int'
	];

	protected $fillable = [
		'service_id',
		'maquila_order_id'
	];

	public function maquila_order()
	{
		return $this->belongsTo(MaquilaOrder::class);
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}
}
