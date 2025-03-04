<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory class for creating User model instances.
 *
 * This factory provides a convenient way to generate fake data for the `User` model,
 * useful for testing or seeding the database. It defines the default state for a User 
 * instance, including values for fields such as name, email, password, DNI, phone, 
 * address, and user type.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * This method defines the default state for the `User` model, using Faker 
     * to generate fake data for each attribute. Fields such as name, email, password, 
     * phone, and address are randomly generated. The `type` attribute is randomly assigned 
     * as either "admin" or "oper".
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), // Nombre del usuario
            'email' => $this->faker->unique()->safeEmail(), // Correo electrónico único
            'email_verified_at' => now(), // Fecha de verificación del correo electrónico
            'password' => bcrypt('password'), // Contraseña por defecto (encriptada)
            'dni' => $this->faker->unique()->numerify('###########'), // DNI único generado
            'phone' => $this->faker->phoneNumber(), // Número de teléfono
            'address' => $this->faker->address(), // Dirección del usuario
            'type' => $this->faker->randomElement(['admin', 'oper']), // Tipo de usuario aleatorio (admin o oper)
        ];
    }

    /**
     * Indicate that the user is an admin.
     *
     * This method allows the factory to generate a user with the 'admin' type.
     * It overrides the default `type` attribute to be 'admin'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): static
    {
        return $this->state([
            'type' => 'admin', // Establece el tipo de usuario como 'admin'
        ]);
    }

    /**
     * Indicate that the user is an operator.
     *
     * This method allows the factory to generate a user with the 'oper' type.
     * It overrides the default `type` attribute to be 'oper'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function oper(): static
    {
        return $this->state([
            'type' => 'oper', // Establece el tipo de usuario como 'oper'
        ]);
    }
}
