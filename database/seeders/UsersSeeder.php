<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder class to populate the 'users' table with sample data.
 *
 * This class is responsible for seeding the `users` table with sample data. It creates 
 * both admin and operator users manually with predefined values and then uses the 
 * `UserFactory` to generate additional random users.
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method inserts sample data into the `users` table. It creates four users 
     * with predefined details, including two admin users and two operator users, 
     * using the `User::create` method. The passwords are hashed using `Hash::make`. 
     * After that, it uses the `UserFactory` to generate 10 additional random users.
     *
     * @return void
     */
    public function run(): void
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'Admin User', // Admin user's name
            'email' => 'admin@example.com', // Admin user's email
            'password' => Hash::make('password'), // Admin user's hashed password
            'dni' => '00000001A', // Admin user's DNI
            'phone' => '123456789', // Admin user's phone number
            'address' => 'Admin Street 1', // Admin user's address
            'type' => 'admin', // User type: admin
        ]);

        User::create([
            'name' => 'Admin User Dos', // Admin user's name
            'email' => 'admindos@example.com', // Admin user's email
            'password' => Hash::make('password'), // Admin user's hashed password
            'dni' => '00000001B', // Admin user's DNI
            'phone' => '123456789', // Admin user's phone number
            'address' => 'Admin Street 1', // Admin user's address
            'type' => 'admin', // User type: admin
        ]);

        // Crear un usuario operador
        User::create([
            'name' => 'Operator User', // Operator user's name
            'email' => 'operator@example.com', // Operator user's email
            'password' => Hash::make('password'), // Operator user's hashed password
            'dni' => '00000002A', // Operator user's DNI
            'phone' => '987654321', // Operator user's phone number
            'address' => 'Operator Avenue 2', // Operator user's address
            'type' => 'oper', // User type: operator
        ]);

        User::create([
            'name' => 'Operator User Dos', // Operator user's name
            'email' => 'operatordos@example.com', // Operator user's email
            'password' => Hash::make('password'), // Operator user's hashed password
            'dni' => '00000002B', // Operator user's DNI
            'phone' => '987654321', // Operator user's phone number
            'address' => 'Operator Avenue 2', // Operator user's address
            'type' => 'oper', // User type: operator
        ]);

        // Create 10 additional random users using the factory
        User::factory(10)->create(); // Create 10 random users using the User factory
    }
}
