<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client; // Asegúrate de importar el modelo Client

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cif' => $this->faker->unique()->numerify('########'), // Genera un CIF numérico único
            'name' => $this->faker->company(), // Genera un nombre de compañía aleatorio
            'phone' => $this->faker->optional()->phoneNumber(), // Genera un número de teléfono opcional
            'email' => $this->faker->unique()->safeEmail(), // Genera un correo electrónico único
            'bank_account' => $this->faker->optional()->iban(), // Genera un IBAN opcional
            'country' => $this->faker->optional()->country(), // Genera un país opcional
            'currency' => $this->faker->randomElement(['eur', 'usd', 'zar']), // Genera una moneda aleatoria
            'monthly_fee' => $this->faker->randomFloat(2, 0, 1000), // Genera una cuota mensual aleatoria
        ];
    }
}
