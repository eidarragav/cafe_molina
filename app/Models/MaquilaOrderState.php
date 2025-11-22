<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaquilaOrderState extends Model
{
    use HasFactory;

    public function maquila_order()
    {
    return $this->belongsTo(MaquilaOrder::class);
    }

    public function state()
    {
    return $this->belongsTo(State::class);
    }

}


