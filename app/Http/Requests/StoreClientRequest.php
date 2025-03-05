<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="StoreClientRequest",
 * title="Store Client Request",
 * description="Request para almacenar un nuevo cliente.",
 * required={"cif", "name", "phone", "email", "bank_account", "country", "monthly_fee"},
 * @OA\Property(property="cif", type="string", description="CIF del cliente."),
 * @OA\Property(property="name", type="string", description="Nombre del cliente."),
 * @OA\Property(property="phone", type="string", description="Teléfono del cliente (9 dígitos)."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del cliente."),
 * @OA\Property(property="bank_account", type="string", description="Cuenta bancaria del cliente."),
 * @OA\Property(property="country", type="string", description="País del cliente."),
 * @OA\Property(property="currency", type="string", description="Moneda del cliente (opcional)."),
 * @OA\Property(property="monthly_fee", type="number", format="float", description="Cuota mensual del cliente.")
 * )
 */
class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to create a new client. 
     * You can add custom authorization logic if necessary.
     *
     * @return bool
     */
    public function authorize()
    {
        // Retorna true si el usuario está autorizado para hacer la solicitud
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for each field when storing a new client.
     * Fields like CIF, email, and phone number are validated to ensure uniqueness and correct formatting.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cif' => 'required|unique:clients,cif',           // CIF único
            'name' => 'required|string|max:255',               // Nombre requerido
            'phone' => 'required|digits:9|regex:/^[0-9]+$/',   // Teléfono requerido y debe ser de 9 dígitos
            'email' => 'required|email|unique:clients,email',  // Email único
            'bank_account' => 'required|string|max:255',       // Cuenta bancaria opcional
            'country' => 'required|string|max:255',            // País obligatorio
            'currency' => 'nullable|string|max:3',             // Moneda opcional
            'monthly_fee' => 'required|numeric|min:0',         // Cuota mensual obligatoria y debe ser numérica
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * This method returns custom error messages for each validation rule,
     * providing users with clear feedback when validation fails.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cif.required' => 'The CIF field is required.',
            'cif.unique' => 'The CIF must be unique.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name must not exceed 255 characters.',
            'phone.required' => 'The phone number is required.',
            'phone.digits' => 'The phone number must be exactly 9 digits.',
            'phone.regex' => 'The phone number must contain only numbers.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email must be unique.',
            'bank_account.required' => 'The bank account field is required.',
            'bank_account.string' => 'The bank account must be a valid string.',
            'bank_account.max' => 'The bank account must not exceed 255 characters.',
            'country.required' => 'The country field is required.',
            'country.max' => 'The country must not exceed 255 characters.',
            'currency.string' => 'The currency must be a valid string.',
            'currency.max' => 'The currency must not exceed 3 characters.',
            'monthly_fee.required' => 'The monthly fee is required.',
            'monthly_fee.numeric' => 'The monthly fee must be a number.',
            'monthly_fee.min' => 'The monthly fee cannot be negative.',
        ];
    }
}
