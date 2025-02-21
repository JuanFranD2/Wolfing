<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Contraseña por defecto
            'dni' => $this->faker->unique()->numerify('###########'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'type' => $this->faker->randomElement(['admin', 'oper']), // Tipo aleatorio
        ];
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): static
    {
        return $this->state([
            'type' => 'admin',
        ]);
    }

    /**
     * Indicate that the user is an operator.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function oper(): static
    {
        return $this->state([
            'type' => 'oper',
        ]);
    }
}
