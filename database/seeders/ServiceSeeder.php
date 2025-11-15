<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        if (DB::table('services')->count() > 0) {
            return;
        }

        $now = now()->toDateTimeString();

        DB::table('services')->insert([
            ['service_type' => 'Tostado', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Molido', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Empaquetado', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Seleccionado', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Clasificado', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
