<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create(['name' => 'Tradicional Rojo']);
        Product::create(['name' => 'Tradicional Gris']);
        Product::create(['name' => 'Orange Bourbon']);
        Product::create(['name' => 'Bourbon Aji']);
        Product::create(['name' => 'Descafeinado']);
        Product::create(['name' => 'Consumo AA']);
        Product::create(['name' => 'Geisha Lemongrass']);
        Product::create(['name' => 'Salamina']);
        Product::create(['name' => 'Supremo Cafe Molina']);
        Product::create(['name' => 'Caturra Peach']);
        Product::create(['name' => 'Sudam Rumé']);
        Product::create(['name' => 'Geisha Delicado']);
    }
}