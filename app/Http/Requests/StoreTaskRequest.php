<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="StoreTaskRequest",
 * title="Store Task Request",
 * description="Request para almacenar una nueva tarea.",
 * required={"client", "contact_person", "description", "contact_phone", "province", "contact_email", "status", "address", "city", "assigned_operator", "previous_notes"},
 * @OA\Property(property="client", type="string", description="Nombre del cliente."),
 * @OA\Property(property="contact_person", type="string", description="Persona de contacto."),
 * @OA\Property(property="description", type="string", description="Descripción de la tarea."),
 * @OA\Property(property="contact_phone", type="string", description="Teléfono de contacto (9 dígitos)."),
 * @OA\Property(property="postal_code", type="string", description="Código postal (5 dígitos, opcional)."),
 * @OA\Property(property="province", type="string", description="Código de la provincia."),
 * @OA\Property(property="contact_email", type="string", format="email", description="Correo electrónico de contacto."),
 * @OA\Property(property="status", type="string", description="Estado de la tarea."),
 * @OA\Property(property="address", type="string", description="Dirección."),
 * @OA\Property(property="city", type="string", description="Ciudad."),
 * @OA\Property(property="assigned_operator", type="integer", description="ID del operador asignado."),
 * @OA\Property(property="previous_notes", type="string", description="Notas previas (opcional).")
 * )
 */
class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to create a new task. 
     * It returns true, assuming that any authenticated user can create a task.
     * You can add additional authorization logic if necessary.
     *
     * @return bool
     */
    public function authorize()
    {
        // Asegúrate de que el usuario esté autenticado
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for each field when creating 
     * a new task, including the client, contact information, and task details.
     * It ensures that fields such as phone number, postal code, and province 
     * meet specific formatting requirements.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client' => 'required|exists:clients,name', // El cliente debe ser obligatorio y coincidir con un nombre de la tabla 'clients'
            'contact_person' => 'required|string|max:255', // La persona de contacto debe tener algún valor
            'description' => 'required|string', // La descripción debe tener algún valor
            'contact_phone' => 'required|digits:9|regex:/^[0-9]+$/', // Teléfono debe ser numérico y tener exactamente 9 dígitos
            'postal_code' => 'nullable|regex:/^\d{5}$/', // Código postal debe tener 5 dígitos
            'province' => 'required|exists:provinces,cod', // La provincia debe ser obligatoria y debe existir en la tabla 'provinces'
            'contact_email' => 'required|email', // El correo debe ser obligatorio y con un formato válido
            'status' => 'required', // El estado debe ser obligatorio
            'address' => 'required|string', // La dirección debe ser obligatoria
            'city' => 'required|string', // La ciudad debe ser obligatoria
            'assigned_operator' => 'required|exists:users,id', // El operador asignado debe ser obligatorio y debe existir un operador con ese id
            'previous_notes' => 'nullable|string', // Campo previous_notes añadido
        ];
    }

    /**
     * Get the custom error messages for validation.
     *
     * This method returns custom error messages for each validation rule,
     * ensuring that users receive clear feedback when validation fails.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client.required' => 'The client field is required.',
            'client.exists' => 'The client does not exist.',
            'contact_person.required' => 'The contact person is required.',
            'description.required' => 'The description is required.',
            'contact_phone.required' => 'The phone number is required',
            'contact_phone.regex' => 'The phone number must be a valid number.',
            'postal_code.regex' => 'The postal code must be 5 digits.',
            'province.required' => 'The province is required.',
            'province.exists' => 'The selected province does not exist.',
            'contact_email.required' => 'The email is required.',
            'contact_email.email' => 'The email must be a valid email address.',
            'address.required' => 'The address is required.',
            'city.required' => 'The city is required.',
            'assigned_operator.required' => 'The assigned operator is required.',
            'assigned_operator.exists' => 'The selected operator does not exist.',
            'previous_notes.string' => 'The previous notes must be a valid string.', // Mensaje de error para previous_notes
        ];
    }
}
