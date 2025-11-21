<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weight;

class WeightSeeder extends Seeder
{
    public function run()
    {
        Weight::create(['presentation' => '250g']);
        Weight::create(['presentation' => '340g']);
        Weight::create(['presentation' => '500g']);
        Weight::create(['presentation' => '1000g']);
        Weight::create(['presentation' => '2500g']);
    }
}