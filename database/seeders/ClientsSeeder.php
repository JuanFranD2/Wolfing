<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear clientes con datos específicos
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
    }
}
