<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Province;
use App\Models\Task;

class TaskFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar los seeders necesarios
        $this->seed(\Database\Seeders\ClientSeeder::class);
        $this->seed(\Database\Seeders\ProvincesSeeder::class); // Asegúrate de que también exista
    }

    /**
     * Prueba el envío del formulario de creación de tareas usando clientes ya existentes.
     *
     * @return void
     */
    public function test_task_form_submission()
    {
        // Obtener el primer cliente existente
        $client = Client::firstOrFail();

        // Obtener cualquier provincia válida
        $province = Province::firstOrFail();

        // Datos del formulario usando los datos del cliente existente
        $taskData = [
            'cif' => $client->cif,
            'contact_person' => $client->name, // Por ejemplo, usamos el nombre como persona de contacto
            'contact_phone' => $client->phone, // Debe coincidir por validación
            'description' => 'Test task description',
            'contact_email' => $client->email,
            'address' => '123 Main St',
            'city' => 'Test City',
            'postal_code' => '12345',
            'province' => $province->cod,
            'previous_notes' => 'Previous notes for test',
        ];

        // Enviar la solicitud POST
        $response = $this->post(route('tasks.storeClientTask'), $taskData);

        // Verificar redirección y mensaje de éxito
        $response->assertRedirect(route('tasks.thanks.client'))
            ->assertSessionHas('task_created', 'Task created successfully!');

        // Verificar que la tarea se haya guardado correctamente
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
            'status' => 'P',
        ]);
    }
}
