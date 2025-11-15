<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {


        $now = now()->toDateTimeString();

        DB::table('packages')->insert([
            ['package_type' => 'Bolsa', 'created_at' => $now, 'updated_at' => $now],
            ['package_type' => 'Caja', 'created_at' => $now, 'updated_at' => $now],
            ['package_type' => 'Saco', 'created_at' => $now, 'updated_at' => $now],
            ['package_type' => 'Tarrina', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}