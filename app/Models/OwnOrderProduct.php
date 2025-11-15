<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OwnOrderProduct
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $own_order_id
 * @property int $product_id
 * @property int $weight_id
 * @property int $quantity
 * 
 * @property OwnOrder $own_order
 * @property Product $product
 * @property Weight $weight
 *
 * @package App\Models
 */
class OwnOrderProduct extends Model
{
	protected $table = 'own_order_products';

	protected $casts = [
		'own_order_id' => 'int',
		'product_id' => 'int',
		'weight_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'own_order_id',
		'product_id',
		'weight_id',
		'quantity'
	];

	public function own_order()
	{
		return $this->belongsTo(OwnOrder::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function weight()
	{
		return $this->belongsTo(Weight::class);
	}
}
