<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder class to seed the application's database with sample data.
 *
 * This class is responsible for calling other seeder classes to populate the database with 
 * sample data. It uses the `run` method to execute the necessary seeders to insert records 
 * into the `users`, `tasks`, `clients`, `fees`, and `provinces` tables.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * This method is executed when running the database seeding command. It calls multiple 
     * seeder classes to insert sample data into the database. The `UsersSeeder`, `TasksSeeder`, 
     * `ClientSeeder`, `FeeSeeder`, and `ProvincesSeeder` are invoked to populate their respective 
     * tables with data. You can also enable other seeder classes by calling them in this method.
     *
     * @return void
     */
    public function run(): void
    {
        /*User::factory(10)->create(); // Create 10 users using the factory
        $this->call([
            //UsersSeeder::class,
        ]);*/

        // Seed the Users table with data
        $this->call(UsersSeeder::class);

        // Seed the Tasks table with data
        $this->call(TasksSeeder::class);

        // Seed the Clients table with data
        $this->call(ClientSeeder::class);

        // Seed the Fees table with data
        $this->call(FeeSeeder::class);

        // Seed the Provinces table with data
        $this->call(ProvincesSeeder::class);
    }
}
