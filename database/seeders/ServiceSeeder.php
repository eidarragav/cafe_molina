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
            ['service_type' => 'Trillado', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Monitoreo', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Tostion', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Molido', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Empaque', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Analisis Granulometrico', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Curva tostion', 'created_at' => $now, 'updated_at' => $now],
            ['service_type' => 'Revision taza', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
