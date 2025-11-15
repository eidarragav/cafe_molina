<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mesh
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $meshe_type
 * @property string $weight
 * 
 * @property Collection|MaquilaMesh[] $maquila_meshes
 *
 * @package App\Models
 */
class Mesh extends Model
{
	protected $table = 'meshes';

	protected $fillable = [
		'meshe_type',
		'weight'
	];

	public function maquila_meshes()
	{
		return $this->hasMany(MaquilaMesh::class);
	}
}
