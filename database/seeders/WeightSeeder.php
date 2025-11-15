<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weight;

class WeightSeeder extends Seeder
{
    public function run()
    {
        Weight::create(['presentation' => '250g']);
        Weight::create(['presentation' => '500g']);
        Weight::create(['presentation' => '1kg']);
    }
}