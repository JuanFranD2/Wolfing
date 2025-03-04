<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder class to populate the 'fees' table with sample data.
 *
 * This class is responsible for seeding the `fees` table with fake data. It uses the 
 * `FeeFactory` to generate and insert 7 sample `Fee` records into the table.
 */
class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method is executed when running the database seeding command. It uses the 
     * `FeeFactory` to generate 7 sample `Fee` records and inserts them into the 
     * `fees` table.
     *
     * @return void
     */
    public function run(): void
    {
        Fee::factory(7)->create(); // Create 7 fee records using the Fee factory
    }
}
