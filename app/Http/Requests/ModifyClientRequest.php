<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="ModifyClientRequest",
 * title="Modify Client Request",
 * description="Request para modificar un cliente existente.",
 * required={"cif", "name", "phone", "email", "monthly_fee"},
 * @OA\Property(property="cif", type="string", description="CIF del cliente."),
 * @OA\Property(property="name", type="string", description="Nombre del cliente."),
 * @OA\Property(property="phone", type="string", description="Teléfono del cliente (9 dígitos)."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del cliente."),
 * @OA\Property(property="bank_account", type="string", description="Cuenta bancaria del cliente (opcional)."),
 * @OA\Property(property="country", type="string", description="País del cliente (opcional)."),
 * @OA\Property(property="currency", type="string", description="Moneda del cliente (opcional)."),
 * @OA\Property(property="monthly_fee", type="number", format="float", description="Cuota mensual del cliente.")
 * )
 */
class ModifyClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method assumes that the user is authorized to modify the client. 
     * It could be extended with custom authorization logic if necessary.
     *
     * @return bool
     */
    public function authorize()
    {
        // Verifica si el usuario tiene autorización para modificar clientes.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for each field when modifying the client,
     * including unique constraints and data type checks.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cif' => 'required|unique:clients,cif,' . $this->input('client'),  // CIF must be unique except for the current client
            'name' => 'required|string|max:255',  // Name is required and should be a string
            'phone' => 'required|string|regex:/^[0-9]{9}$/',  // Phone must be a valid 9-digit number
            'email' => 'required|email|unique:clients,email,' . $this->input('client'),  // Email must be unique
            'bank_account' => 'nullable|string|max:255',  // Bank account is optional
            'country' => 'nullable|string|max:255',  // Country is optional
            'currency' => 'nullable|string|max:3',  // Currency is optional and should be 3 characters
            'monthly_fee' => 'required|numeric|min:0',  // Monthly fee must be a non-negative number
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * This method returns custom error messages for each validation rule,
     * ensuring the user receives clear feedback when validation fails.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cif.required' => 'The CIF field is required.',
            'cif.unique' => 'The CIF must be unique.',
            'name.required' => 'The name field is required.',
            'phone.required' => 'The phone number field is required.',
            'phone.regex' => 'The phone number must contain exactly 9 digits.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email must be unique.',
            'monthly_fee.required' => 'The monthly fee is required.',
            'monthly_fee.numeric' => 'The monthly fee must be a number.',
            'monthly_fee.min' => 'The monthly fee cannot be negative.',
        ];
    }
}
