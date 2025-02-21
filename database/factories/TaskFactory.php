<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client' => 'hora', // Nombre del cliente fijo
            'contact_person' => $this->faker->name,
            'contact_phone' => $this->faker->phoneNumber,
            'description' => $this->faker->sentence(10),
            'contact_email' => $this->faker->safeEmail,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'province' => str_pad($this->faker->numberBetween(1, 50), 2, '0', STR_PAD_LEFT), // Código de provincia con dos dígitos
            'status' => $this->faker->randomElement(['P', 'R', 'C', 'E', 'X']),
            'assigned_operator' => 3, // Opcional, cambiar por IDs reales si tienes usuarios
            'realization_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'), // Generar una fecha aleatoria en formato Y-m-d H:i:s
            'previous_notes' => $this->faker->text(200),
            'subsequent_notes' => $this->faker->text(200),
            'summary_file' => null, // Puede ser una ruta de archivo o null
        ];
    }
}
