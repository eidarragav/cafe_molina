<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);

        // Worker users
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ana Martínez',
            'email' => 'ana@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Pedro Rodríguez',
            'email' => 'pedro@cafemolina.com',
            'password' => Hash::make('password123'),
        ]);
    }
}