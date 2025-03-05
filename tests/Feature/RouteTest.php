<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Client;
use App\Models\Fee;

class RouteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $operUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->admin()->create();
        $this->operUser = User::factory()->oper()->create();
    }

    public function test_root_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_admin_routes_require_admin_role()
    {
        $response = $this->actingAs($this->adminUser)->get('/operUsers');
        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)->get('/tasks');
        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)->get('/clients');
        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)->get('/fees');
        $response->assertStatus(200);
    }

    public function test_oper_routes_require_oper_role()
    {
        $response = $this->actingAs($this->operUser)->get('/tasksOper');
        $response->assertStatus(200);
    }

    public function test_client_task_routes()
    {
        $response = $this->get('/tasks/create/client');
        $response->assertStatus(200);

        $response = $this->get('/thanks-client');
        $response->assertStatus(200);
    }

    public function test_resource_routes()
    {
        $this->actingAs($this->adminUser);

        $user = User::factory()->create();
        $task = Task::factory()->create();
        $client = Client::factory()->create();
        $fee = Fee::factory()->create();

        $this->get(route('operUsers.index'))->assertStatus(200);
        $this->get(route('operUsers.create'))->assertStatus(200);
        $this->post(route('operUsers.store'), $user->toArray())->assertStatus(302);
        $this->get(route('operUsers.show', $user->id))->assertStatus(200);
        $this->get(route('operUsers.edit', $user->id))->assertStatus(200);
        $this->put(route('operUsers.update', $user->id), $user->toArray())->assertStatus(302);
        $this->delete(route('operUsers.destroy', $user->id))->assertStatus(302);

        $this->get(route('tasks.index'))->assertStatus(200);
        $this->get(route('tasks.create'))->assertStatus(200);
        $this->post(route('tasks.store'), $task->toArray())->assertStatus(302);
        $this->get(route('tasks.show', $task->id))->assertStatus(200);
        $this->get(route('tasks.edit', $task->id))->assertStatus(200);
        $this->put(route('tasks.update', $task->id), $task->toArray())->assertStatus(302);
        $this->delete(route('tasks.destroy', $task->id))->assertStatus(302);

        $this->get(route('clients.index'))->assertStatus(200);
        $this->get(route('clients.create'))->assertStatus(200);
        $this->post(route('clients.store'), $client->toArray())->assertStatus(302);
        $this->get(route('clients.show', $client->id))->assertStatus(200);
        $this->get(route('clients.edit', $client->id))->assertStatus(200);
        $this->put(route('clients.update', $client->id), $client->toArray())->assertStatus(302);
        $this->delete(route('clients.destroy', $client->id))->assertStatus(302);

        $this->get(route('fees.index'))->assertStatus(200);
        $this->get(route('fees.createExtraordinaryFee'))->assertStatus(200);
        $this->post(route('fees.store'), $fee->toArray())->assertStatus(302);
        $this->get(route('fees.show', $fee->id))->assertStatus(200);
        $this->get(route('fees.edit', $fee->id))->assertStatus(200);
        $this->put(route('fees.update', $fee->id), $fee->toArray())->assertStatus(302);
        $this->delete(route('fees.destroy', $fee->id))->assertStatus(302);
    }
}
