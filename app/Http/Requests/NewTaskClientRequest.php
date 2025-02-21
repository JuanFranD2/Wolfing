<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Client;
use Illuminate\Validation\Rule;

class NewTaskClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Permitir a todos los usuarios
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
            'cif' => [
                'required',
                'exists:clients,cif',  // El CIF debe existir en la base de datos
            ],
            'contact_person' => 'required|string|max:255', // La persona de contacto es obligatoria
            'contact_phone' => [
                'required',
                'digits:9', // El teléfono debe ser numérico y de 9 dígitos
                'regex:/^[0-9]+$/', // Solo números
                function ($attribute, $value, $fail) {
                    // Validar que el teléfono coincida con el teléfono del cliente
                    $client = Client::where('cif', $this->cif)->first();  // Buscar el cliente por CIF
                    if ($client && $client->phone != $value) {
                        return $fail('The phone number does not match the registered number for this client.');
                    }
                }
            ],
            'description' => 'required|string', // La descripción es obligatoria
            'contact_email' => 'required|email', // El correo electrónico es obligatorio y debe ser válido
            'address' => 'required|string', // La dirección es obligatoria
            'city' => 'required|string', // La ciudad es obligatoria
            'postal_code' => 'required|digits:5', // El código postal debe tener 5 dígitos
            'province' => 'required|exists:provinces,cod', // La provincia debe ser válida
            'previous_notes' => 'nullable|string', // Las notas previas son opcionales
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
            'cif.required' => 'The CIF field is required.',
            'cif.exists' => 'The client with the given CIF does not exist.',
            'contact_phone.required' => 'The contact phone number is required.',
            'contact_phone.digits' => 'The phone number must be exactly 9 digits.',
            'contact_phone.regex' => 'The phone number must contain only numbers.',
            'description.required' => 'The description is required.',
            'contact_email.required' => 'The email is required.',
            'contact_email.email' => 'The email must be a valid email address.',
            'address.required' => 'The address is required.',
            'city.required' => 'The city is required.',
            'postal_code.required' => 'The postal code is required.',
            'postal_code.digits' => 'The postal code must be 5 digits.',
            'province.required' => 'The province is required.',
            'province.exists' => 'The selected province does not exist.',
        ];
    }
}
