<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductWeight
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_id
 * @property int $weight_id
 * 
 * @property Product $product
 * @property Weight $weight
 *
 * @package App\Models
 */
class ProductWeight extends Model
{
	protected $table = 'product_weights';

	protected $casts = [
		'product_id' => 'int',
		'weight_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'weight_id'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function weight()
	{
		return $this->belongsTo(Weight::class);
	}
}
