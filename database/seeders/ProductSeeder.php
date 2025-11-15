<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create(['name' => 'Café Supremo']);
        Product::create(['name' => 'Café Tostado Oscuro']);
        Product::create(['name' => 'Café Premium Arábica']);
        Product::create(['name' => 'Café Molido Fino']);
        Product::create(['name' => 'Café Descafeinado']);
    }
}