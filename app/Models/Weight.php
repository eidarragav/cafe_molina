<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Weight
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $presentation
 * 
 * @property Collection|OwnOrderProduct[] $own_order_products
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Weight extends Model
{
	protected $table = 'weights';

	protected $fillable = [
		'presentation'
	];

	public function own_order_products()
	{
		return $this->hasMany(OwnOrderProduct::class);
	}

}
