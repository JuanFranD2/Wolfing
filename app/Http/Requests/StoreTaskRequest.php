<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'contact_email' => 'required|email',
            'status' => 'required', // El correo debe ser obligatorio y con un formato válido
            'address' => 'required|string', // La dirección debe ser obligatoria
            'city' => 'required|string', // La ciudad debe ser obligatoria
            'assigned_operator' => 'required|exists:users,id', // El operador asignado debe ser obligatorio y debe existir un operador con ese id
            'previous_notes' => 'nullable|string', // Campo previous_notes añadido
        ];
    }

    /**
     * Get the custom error messages for validation.
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
