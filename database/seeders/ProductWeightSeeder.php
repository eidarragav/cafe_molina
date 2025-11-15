<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductWeight;

class ProductWeightSeeder extends Seeder
{
    public function run()
    {
        // Café Supremo (id: 1) with all weights
        ProductWeight::create(['product_id' => 1, 'weight_id' => 1]);
        ProductWeight::create(['product_id' => 1, 'weight_id' => 2]);
        ProductWeight::create(['product_id' => 1, 'weight_id' => 3]);

        // Café Tostado Oscuro (id: 2)
        ProductWeight::create(['product_id' => 2, 'weight_id' => 1]);
        ProductWeight::create(['product_id' => 2, 'weight_id' => 2]);

        // Café Premium Arábica (id: 3)
        ProductWeight::create(['product_id' => 3, 'weight_id' => 2]);
        ProductWeight::create(['product_id' => 3, 'weight_id' => 3]);

        // Café Molido Fino (id: 4)
        ProductWeight::create(['product_id' => 4, 'weight_id' => 1]);
        ProductWeight::create(['product_id' => 4, 'weight_id' => 3]);

        // Café Descafeinado (id: 5)
        ProductWeight::create(['product_id' => 5, 'weight_id' => 2]);
    }
}