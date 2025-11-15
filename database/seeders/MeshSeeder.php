<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MeshSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('meshes')) {
            return;
        }

        if (DB::table('meshes')->count() > 0) {
            return;
        }

        $now = now()->toDateTimeString();

        DB::table('meshes')->insert([
            ['meshe_type' => 'Malla #10', 'weight' => '500g', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla #20', 'weight' => '1kg', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla #30', 'weight' => '2kg', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla Fina', 'weight' => '250g', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}