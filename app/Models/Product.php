<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * 
 * @property Collection|OwnOrder[] $own_orders
 * @property Collection|Weight[] $weights
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $fillable = [
		'name'
	];

	public function own_orders()
	{
		return $this->belongsToMany(OwnOrder::class, 'own_order_products')
					->withPivot('id', 'weight_id', 'quantity')
					->withTimestamps();
	}

	public function product_weight()
	{
		return $this->hasMany(ProductWeight::class);
	}
}
