<?php

// Ejemplo de un Factory de Fee
namespace Database\Factories;

use App\Models\Client;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeFactory extends Factory
{
    protected $model = Fee::class;

    public function definition()
    {
        // Crea un cliente relacionado
        $client = Client::factory()->create();

        return [
            'cif' => $client->cif, // Usa el cif del cliente creado
            'concept' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'issue_date' => $this->faker->date(),
            'passed' => 'N',
            'payment_date' => null,
            'notes' => $this->faker->text,
        ];
    }
}
