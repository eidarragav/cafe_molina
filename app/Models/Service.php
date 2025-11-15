<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $service_type
 * 
 * @property Collection|MaquilaService[] $maquila_services
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';

	protected $fillable = [
		'service_type'
	];

	public function maquila_services()
	{
		return $this->hasMany(MaquilaService::class);
	}
}
