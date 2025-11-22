<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaquilaOrder
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $costumer_id
 * @property string $quality_type
 * @property string $toast_type
 * @property string $recieved_kilograms
 * @property string $coffe_type
 * @property string $green_density
 * @property string $green_humidity
 * @property string $tag
 * @property string $peel_stick
 * @property string $printed_label
 * @property string $observations
 * @property string $urgent_order
 * @property string $status
 * 
 * @property Costumer $costumer
 * @property User $user
 * @property Collection|MaquilaMesh[] $maquila_meshes
 * @property Collection|MaquilaPackage[] $maquila_packages
 * @property Collection|MaquilaService[] $maquila_services
 * @property Collection|Toast[] $toasts
 *
 * @package App\Models
 */
class MaquilaOrder extends Model
{
	protected $table = 'maquila_orders';

	protected $casts = [
		'user_id' => 'int',
		'costumer_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'costumer_id',
		'quality_type',
		'toast_type',
		'recieved_kilograms',
		'coffe_type',
		'green_density',
		'green_humidity',
		'tag',
		'peel_stick',
		'printed_label',
		'observations',
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

	public function maquila_meshes()
	{
		return $this->hasMany(MaquilaMesh::class);
	}

	public function maquila_packages()
	{
		return $this->hasMany(MaquilaPackage::class);
	}

	public function maquila_services()
	{
		return $this->hasMany(MaquilaService::class);
	}

	public function toasts()
	{
		return $this->hasMany(Toast::class);
	}

	public function maquila_order_states()
	{
    return $this->hasMany(MaquilaOrderState::class);
	}	
}
