<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory class for creating Fee model instances.
 *
 * This factory provides a convenient way to generate fake data for the `Fee` model,
 * useful for testing or seeding the database. It defines the default state for a Fee 
 * instance, including values for fields such as CIF, concept, issue date, amount, 
 * passed status, payment date, and notes.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * This method defines the default state for the `Fee` model, using Faker 
     * to generate fake data for each attribute. The CIF is fixed, but other fields 
     * like concept, issue date, amount, passed status, payment date, and notes 
     * are generated randomly or optionally.
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
