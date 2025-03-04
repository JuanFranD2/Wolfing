<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory class for creating Task model instances.
 *
 * This factory provides a convenient way to generate fake data for the `Task` model,
 * useful for testing or seeding the database. It defines the default state for a Task 
 * instance, including values for fields such as client, contact person, contact information, 
 * description, status, assigned operator, realization date, notes, and summary file.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * This method defines the default state for the `Task` model, using Faker 
     * to generate fake data for each attribute. Fields such as client name, contact 
     * information, description, status, and notes are generated randomly. 
     * The realization date is randomly generated within the past year, 
     * and the province code is formatted with two digits.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client' => 'hora', // Nombre del cliente fijo
            'contact_person' => $this->faker->name, // Nombre del contacto
            'contact_phone' => $this->faker->phoneNumber, // Teléfono de contacto
            'description' => $this->faker->sentence(10), // Descripción de la tarea
            'contact_email' => $this->faker->safeEmail, // Correo electrónico del contacto
            'address' => $this->faker->address, // Dirección
            'city' => $this->faker->city, // Ciudad
            'postal_code' => $this->faker->postcode, // Código postal
            'province' => str_pad($this->faker->numberBetween(1, 50), 2, '0', STR_PAD_LEFT), // Código de provincia con dos dígitos
            'status' => $this->faker->randomElement(['P', 'R', 'C', 'E', 'X']), // Estado de la tarea
            'assigned_operator' => 3, // ID del operador asignado (opcional, se puede cambiar por un ID real)
            'realization_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'), // Fecha de realización generada aleatoriamente
            'previous_notes' => $this->faker->text(200), // Notas previas
            'subsequent_notes' => $this->faker->text(200), // Notas posteriores
            'summary_file' => null, // Archivo resumen (opcional, puede ser una ruta o null)
        ];
    }
}
