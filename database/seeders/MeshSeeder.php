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
            ['meshe_type' => 'Malla #18', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla #17', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla #15', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Malla #14', 'created_at' => $now, 'updated_at' => $now],
            ['meshe_type' => 'Fondo', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}