<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Costumer
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $cedula
 * @property string $phone
 * @property string $farm
 * 
 * @property Collection|MaquilaOrder[] $maquila_orders
 * @property Collection|OwnOrder[] $own_orders
 *
 * @package App\Models
 */
class Costumer extends Model
{
	protected $table = 'costumers';

	protected $fillable = [
		'name',
		'cedula',
		'phone',
		'farm'
	];

	public function maquila_orders()
	{
		return $this->hasMany(MaquilaOrder::class);
	}

	public function own_orders()
	{
		return $this->hasMany(OwnOrder::class);
	}
}
