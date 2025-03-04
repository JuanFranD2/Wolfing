<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::factory(10)->create();
        $this->call([
            //UsersSeeder::class,
        ]);*/

        $this->call(UsersSeeder::class);

        $this->call(TasksSeeder::class);

        $this->call(ClientSeeder::class);

        $this->call(FeeSeeder::class);

        $this->call(ProvincesSeeder::class);
    }
}
