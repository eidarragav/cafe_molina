<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MeasureSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('measures')) {
            return;
        }

        if (DB::table('measures')->count() > 0) {
            return;
        }

        $now = now()->toDateTimeString();

        DB::table('measures')->insert([
            ['measure_type' => 'kg', 'created_at' => $now, 'updated_at' => $now],
            ['measure_type' => 'lbs', 'created_at' => $now, 'updated_at' => $now],
            ['measure_type' => 'g', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}