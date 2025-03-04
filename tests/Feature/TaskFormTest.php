<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Province;
use App\Models\Task;

/**
 * Feature test for task creation form submission.
 *
 * This test verifies the behavior of the task creation form, ensuring that it works correctly 
 * when submitting data for an existing client and province. It checks if the form submission 
 * successfully creates a task and validates the task data in the database.
 */
class TaskFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test environment.
     *
     * This method runs the necessary seeders for the test, ensuring that there are existing
     * clients and provinces in the database.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with clients and provinces
        $this->seed(\Database\Seeders\ClientSeeder::class);
        $this->seed(\Database\Seeders\ProvincesSeeder::class); // Ensure provinces are also seeded
    }

    /**
     * Test the task form submission using existing clients and provinces.
     *
     * This test submits the task creation form with data for an existing client and a valid province.
     * It then checks that the task is correctly created and stored in the database, and that the 
     * user is redirected with the appropriate success message.
     *
     * @return void
     */
    public function test_task_form_submission()
    {
        // Get the first existing client
        $client = Client::firstOrFail();

        // Get any valid province
        $province = Province::firstOrFail();

        // Task form data using the existing client's information
        $taskData = [
            'cif' => $client->cif,
            'contact_person' => $client->name, // Use the client's name as the contact person
            'contact_phone' => $client->phone, // The phone should match for validation
            'description' => 'Test task description',
            'contact_email' => $client->email,
            'address' => '123 Main St',
            'city' => 'Test City',
            'postal_code' => '12345',
            'province' => $province->cod,
            'previous_notes' => 'Previous notes for test',
        ];

        // Submit the form via POST request
        $response = $this->post(route('tasks.storeClientTask'), $taskData);

        // Verify redirection and success message in the session
        $response->assertRedirect(route('tasks.thanks.client'))
            ->assertSessionHas('task_created', 'Task created successfully!');

        // Verify that the task was stored in the database
        $this->assertDatabaseHas('tasks', [
            'client' => $client->name,
            'contact_person' => $taskData['contact_person'],
            'contact_phone' => $taskData['contact_phone'],
            'description' => $taskData['description'],
            'contact_email' => $taskData['contact_email'],
            'address' => $taskData['address'],
            'city' => $taskData['city'],
            'postal_code' => $taskData['postal_code'],
            'province' => $taskData['province'],
            'previous_notes' => $taskData['previous_notes'],
            'status' => 'P', // Ensure the task is created with status 'P' (Pending)
        ]);
    }
}
