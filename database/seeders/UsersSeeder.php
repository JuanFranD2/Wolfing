<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'dni' => '00000001A',
            'phone' => '123456789',
            'address' => 'Admin Street 1',
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Admin User Dos',
            'email' => 'admindos@example.com',
            'password' => Hash::make('password'),
            'dni' => '00000001B',
            'phone' => '123456789',
            'address' => 'Admin Street 1',
            'type' => 'admin',
        ]);

        // Crear un usuario operador
        User::create([
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => Hash::make('password'),
            'dni' => '00000002A',
            'phone' => '987654321',
            'address' => 'Operator Avenue 2',
            'type' => 'oper',
        ]);

        User::create([
            'name' => 'Operator User Dos',
            'email' => 'operatordos@example.com',
            'password' => Hash::make('password'),
            'dni' => '00000002B',
            'phone' => '987654321',
            'address' => 'Operator Avenue 2',
            'type' => 'oper',
        ]);

        User::factory(10)->create();
    }
}
