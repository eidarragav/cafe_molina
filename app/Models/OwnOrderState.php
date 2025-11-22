<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnOrderState extends Model
{
    use HasFactory;

    public function own_order()
    {
    return $this->belongsTo(OwnOrder::class);
    }

    public function state()
    {
    return $this->belongsTo(State::class);
    }
}
