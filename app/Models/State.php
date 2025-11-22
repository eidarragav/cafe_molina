<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function maquila_order_states()
    {
    return $this->hasMany(MaquilaOrderState::class);
    }

    public function own_order_states()
    {
    return $this->hasMany(OwnOrderState::class);
    }


}
