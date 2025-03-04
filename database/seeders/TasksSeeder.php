<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder class to populate the 'tasks' table with sample data.
 *
 * This class is responsible for seeding the `tasks` table with fake data. It uses the 
 * `TaskFactory` to generate and insert 30 sample `Task` records into the table.
 */
class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method uses the `TaskFactory` to generate 30 sample `Task` records 
     * and inserts them into the `tasks` table. The factory provides a convenient 
     * way to create random data for the `Task` model.
     *
     * @return void
     */
    public function run(): void
    {
        Task::factory(30)->create(); // Create 30 task records using the Task factory
    }
}
