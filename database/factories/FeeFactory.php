<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cif' => '11111111ASDF', // CIF fijo
            'concept' => $this->faker->sentence(3), // Concepto del cargo
            'issue_date' => $this->faker->dateTimeBetween('-1 year', 'now'), // Fecha de emisión
            'amount' => $this->faker->randomFloat(2, 10, 1000), // Importe aleatorio
            'passed' => $this->faker->randomElement(['S', 'N']), // Pasada S/N
            'payment_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'), // Fecha de pago (opcional)
            'notes' => $this->faker->optional()->text(200), // Notas adicionales
        ];
    }
}
