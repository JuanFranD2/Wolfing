<?php

namespace Tests\Feature;

use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{

    /**
     * Prueba que la ruta raíz redirige a /login.
     *
     * @return void
     */
    public function test_root_route_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    /**
     * Prueba que la ruta /dashboard requiere autenticación.
     *
     * @return void
     */
    public function test_dashboard_route_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Prueba que la ruta /dashboard devuelve una respuesta 200 para usuarios autenticados.
     *
     * @return void
     */
    public function test_dashboard_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Prueba que la ruta /tasks requiere autenticación.
     *
     * @return void
     */

    /**
     * Prueba que la ruta /tasks devuelve una respuesta 200 para usuarios autenticados.
     *
     * @return void
     */
    public function test_tasks_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/tasks');
        $response->assertStatus(200);
    }

    /**
     * Prueba que la ruta /clients devuelve una respuesta 200 para usuarios autenticados.
     *
     * @return void
     */
    public function test_clients_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/clients');
        $response->assertStatus(200);
    }

    /**
     * Prueba que la ruta /users/oper requiere autenticación.
     *
     * @return void
     */
    public function test_users_oper_route_requires_authentication()
    {
        $response = $this->get('/users/oper');
        $response->assertRedirect('/login');
    }

    /**
     * Prueba que la ruta /users/oper devuelve una respuesta 200 para usuarios autenticados.
     *
     * @return void
     */
    public function test_users_oper_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/users/oper');
        $response->assertStatus(200);
    }
}
