<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Costumer;

class CostumerSeeder extends Seeder
{
    public function run()
    {
        Costumer::create([
            'name' => 'Finca La Esperanza',
            'cedula' => '1001234567',
            'phone' => '+57 300 111 2222',
            'farm' => 'La Esperanza'
        ]);

        Costumer::create([
            'name' => 'El Roble',
            'cedula' => '1002345678',
            'phone' => '+57 300 222 3333',
            'farm' => 'El Roble'
        ]);

        Costumer::create([
            'name' => 'Montes Verdes',
            'cedula' => '1003456789',
            'phone' => '+57 300 333 4444',
            'farm' => 'Montes Verdes'
        ]);

        Costumer::create([
            'name' => 'La Bendición',
            'cedula' => '1004567890',
            'phone' => '+57 300 444 5555',
            'farm' => 'La Bendición'
        ]);

        Costumer::create([
            'name' => 'Finca Santa Ana',
            'cedula' => '1005678901',
            'phone' => '+57 300 555 6666',
            'farm' => 'Santa Ana'
        ]);

        Costumer::create([
            'name' => 'Cosecha Dorada',
            'cedula' => '1006789012',
            'phone' => '+57 300 666 7777',
            'farm' => 'Cosecha Dorada'
        ]);

        Costumer::create([
            'name' => 'Valle del Café',
            'cedula' => '1007890123',
            'phone' => '+57 300 777 8888',
            'farm' => 'Valle del Café'
        ]);
    }
}