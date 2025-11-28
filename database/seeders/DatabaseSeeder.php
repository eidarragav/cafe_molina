<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            WeightSeeder::class,
            ProductWeightSeeder::class,
            CostumerSeeder::class,
            MeasureSeeder::class,
            MeshSeeder::class,
            ServiceSeeder::class,
            StateSeeder::class,
            PackagingSeeder::class,
            
        ]);
    }
}
