<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StateSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('states')) {
            return;
        }

        if (DB::table('states')->count() > 0) {
            return;
        }

        $now = now()->toDateTimeString();

        $states = [
            'AlmacenamientoInicial',
            'Trillado',
            'Monitoreo',
            'AlmacenamientoFinal',
            'Tostion',
            'Desgasificacion',
            'Filtrado',
            'Molido',
            'Empaquetado',
            'Almacenado',
            'Terminado',
        ];

        $inserts = [];
        foreach ($states as $name) {
            $inserts[] = ['name' => $name, 'created_at' => $now, 'updated_at' => $now];
        }

        DB::table('states')->insert($inserts);
    }
}
