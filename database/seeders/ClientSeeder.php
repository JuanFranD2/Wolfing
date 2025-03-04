<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client; // Importa el modelo Client

/**
 * Seeder class to populate the 'clients' table with sample data.
 *
 * This class is responsible for creating and inserting sample client data into the
 * `clients` table in the database. It demonstrates how to create multiple client records
 * using the `Client` model, which includes fields such as CIF, name, phone, email, 
 * bank account, country, currency, and monthly fee.
 */
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method inserts sample data for clients into the database. Each client 
     * has a unique CIF, name, phone, email, bank account, country, currency, and monthly fee.
     * The `create` method of the `Client` model is used to insert the records into the table.
     *
     * @return void
     */
    public function run(): void
    {
        // Ejemplo de creación de clientes
        Client::create([
            'cif' => '111AAA', // Client CIF (Fiscal Identification Code)
            'name' => 'John Doe', // Client's name
            'phone' => '111222333', // Client's phone number
            'email' => 'johndoe@example.com', // Client's email address
            'bank_account' => 'ES9121000418450200051332', // Client's bank account number
            'country' => 'Spain', // Client's country
            'currency' => 'EUR', // Client's currency
            'monthly_fee' => 0, // Monthly fee for the client (0 for free)
        ]);

        Client::create([
            'cif' => '222BBB', // Client CIF (Fiscal Identification Code)
            'name' => 'Jane Smith', // Client's name
            'phone' => '444555666', // Client's phone number
            'email' => 'janesmith@example.com', // Client's email address
            'bank_account' => 'ES9121000418450200051333', // Client's bank account number
            'country' => 'France', // Client's country
            'currency' => 'EUR', // Client's currency
            'monthly_fee' => 100, // Monthly fee for the client
        ]);

        // Añade más clientes si es necesario
    }
}
