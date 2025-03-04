<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client; // Importa el modelo Client

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ejemplo de creación de clientes
        Client::create([
            'cif' => '111AAA',
            'name' => 'John Doe',
            'phone' => '111222333',
            'email' => 'johndoe@example.com',
            'bank_account' => 'ES9121000418450200051332',
            'country' => 'Spain',
            'currency' => 'EUR',
            'monthly_fee' => 0,
        ]);

        Client::create([
            'cif' => '222BBB',
            'name' => 'Jane Smith',
            'phone' => '444555666',
            'email' => 'janesmith@example.com',
            'bank_account' => 'ES9121000418450200051333',
            'country' => 'France',
            'currency' => 'EUR',
            'monthly_fee' => 100,
        ]);

        // Añade más clientes si es necesario
    }
}
