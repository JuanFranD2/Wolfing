<?php

namespace Tests\Feature;

use App\Models\User; // Import the User model to interact with user data in the tests
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * This class contains feature tests for routing functionality.
 * It includes tests to ensure routes behave as expected, 
 * particularly regarding authentication requirements and 
 * HTTP status responses for different routes in the application.
 */
class RouteTest extends TestCase
{
    /**
     * Test that the root route redirects to /login.
     *
     * This test checks that when a user accesses the root URL ('/'),
     * they are redirected to the login page ('/login').
     *
     * @return void
     */
    public function test_root_route_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login'); // Assert that the response redirects to '/login'
    }

    /**
     * Test that the /dashboard route requires authentication.
     *
     * This test ensures that if an unauthenticated user attempts 
     * to access the '/dashboard' route, they will be redirected 
     * to the login page.
     *
     * @return void
     */
    public function test_dashboard_route_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login'); // Assert that unauthenticated users are redirected to '/login'
    }

    /**
     * Test that the /dashboard route returns a 200 response for authenticated users.
     *
     * This test ensures that when an authenticated user accesses 
     * the '/dashboard' route, they receive a successful HTTP status (200).
     *
     * @return void
     */
    public function test_dashboard_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create(); // Create a new user for the test
        $response = $this->actingAs($user)->get('/dashboard'); // Simulate the user as authenticated
        $response->assertStatus(200); // Assert that the response status is 200 (OK)
    }

    /**
     * Test that the /tasks route requires authentication.
     *
     * This test ensures that unauthenticated users are redirected 
     * to the login page when they attempt to access the '/tasks' route.
     *
     * @return void
     */
    public function test_tasks_route_requires_authentication()
    {
        $response = $this->get('/tasks');
        $response->assertRedirect('/login'); // Assert that unauthenticated users are redirected to '/login'
    }

    /**
     * Test that the /tasks route returns a 200 response for authenticated users.
     *
     * This test ensures that when an authenticated user accesses 
     * the '/tasks' route, they receive a successful HTTP status (200).
     *
     * @return void
     */
    public function test_tasks_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create(); // Create a new user for the test
        $response = $this->actingAs($user)->get('/tasks'); // Simulate the user as authenticated
        $response->assertStatus(200); // Assert that the response status is 200 (OK)
    }

    /**
     * Test that the /clients route returns a 200 response for authenticated users.
     *
     * This test ensures that when an authenticated user accesses 
     * the '/clients' route, they receive a successful HTTP status (200).
     *
     * @return void
     */
    public function test_clients_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create(); // Create a new user for the test
        $response = $this->actingAs($user)->get('/clients'); // Simulate the user as authenticated
        $response->assertStatus(200); // Assert that the response status is 200 (OK)
    }

    /**
     * Test that the /users/oper route requires authentication.
     *
     * This test ensures that unauthenticated users are redirected 
     * to the login page when they attempt to access the '/users/oper' route.
     *
     * @return void
     */
    public function test_users_oper_route_requires_authentication()
    {
        $response = $this->get('/users/oper');
        $response->assertRedirect('/login'); // Assert that unauthenticated users are redirected to '/login'
    }

    /**
     * Test that the /users/oper route returns a 200 response for authenticated users.
     *
     * This test ensures that when an authenticated user accesses 
     * the '/users/oper' route, they receive a successful HTTP status (200).
     *
     * @return void
     */
    public function test_users_oper_route_returns_200_for_authenticated_users()
    {
        $user = User::factory()->create(); // Create a new user for the test
        $response = $this->actingAs($user)->get('/users/oper'); // Simulate the user as authenticated
        $response->assertStatus(200); // Assert that the response status is 200 (OK)
    }
}
