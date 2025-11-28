<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packagings = [
            ['package_type' => 'negro'],
            ['package_type' => 'plateado'],
            ['package_type' => 'muestras'],
            ['package_type' => 'kraft'],
            ['package_type' => 'dorado_flow'],
            ['package_type' => 'negro_flow'],
            ['package_type' => 'blanco'],
            ['package_type' => 'azul_zipper'],
            ['package_type' => 'blanco_zipper'],
        ];

        foreach ($packagings as $packaging) {
            \DB::table('packages')->insert($packaging);
        }
    }
}
