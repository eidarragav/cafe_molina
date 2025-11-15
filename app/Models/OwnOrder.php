<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OwnOrder
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $costumer_id
 * @property Carbon $entry_date
 * @property string $urgent_order
 * @property string $status
 * 
 * @property Costumer $costumer
 * @property User $user
 * @property Collection|Product[] $products
 * @property Collection|Toast[] $toasts
 *
 * @package App\Models
 */
class OwnOrder extends Model
{
	protected $table = 'own_orders';

	protected $casts = [
		'user_id' => 'int',
		'costumer_id' => 'int',
		'entry_date' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'costumer_id',
		'entry_date',
		'urgent_order',
		'status'
	];

	public function costumer()
	{
		return $this->belongsTo(Costumer::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function own_order_product()
	{
		return $this->hasMany(OwnOrderProduct::class);
	}

	public function toasts()
	{
		return $this->hasMany(Toast::class);
	}
}
