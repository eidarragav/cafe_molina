<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Toast
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $own_order_id
 * @property int $maquila_order_id
 * @property string $start_weight
 * @property string $decrease
 * 
 * @property MaquilaOrder $maquila_order
 * @property OwnOrder $own_order
 *
 * @package App\Models
 */
class Toast extends Model
{
	protected $table = 'toasts';

	protected $casts = [
		// Removed casts for foreign keys so nullable null is handled correctly
	];

	protected $fillable = [
		'own_order_id',
		'maquila_order_id',
		'start_weight',
		'decrease',
		'final_weight'
	];

	public function maquila_order()
	{
		return $this->belongsTo(MaquilaOrder::class);
	}

	public function own_order()
	{
		return $this->belongsTo(OwnOrder::class);
	}
}
