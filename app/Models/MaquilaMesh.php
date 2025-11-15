<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaquilaMesh
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $maquila_order_id
 * @property int $meshe_id
 * 
 * @property MaquilaOrder $maquila_order
 * @property Mesh $mesh
 *
 * @package App\Models
 */
class MaquilaMesh extends Model
{
	protected $table = 'maquila_meshes';

	protected $casts = [
		'maquila_order_id' => 'int',
		'meshe_id' => 'int'
	];

	protected $fillable = [
		'maquila_order_id',
		'meshe_id'
	];

	public function maquila_order()
	{
		return $this->belongsTo(MaquilaOrder::class);
	}

	public function mesh()
	{
		return $this->belongsTo(Mesh::class);
	}
}
