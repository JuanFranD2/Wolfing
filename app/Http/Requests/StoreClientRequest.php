<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        return [
            'cif' => 'required|unique:clients,cif',           // CIF único
            'name' => 'required|string|max:255',               // Nombre requerido
            'phone' => 'required|digits:9|regex:/^[0-9]+$/',               // Teléfono opcional
            'email' => 'required|email|unique:clients,email',  // Email único
            'bank_account' => 'required|string|max:255',       // Cuenta bancaria opcional
            'country' => 'required|string|max:255',            // País opcional
            'currency' => 'nullable|string|max:3',             // Moneda opcional
            'monthly_fee' => 'required|numeric|min:0',         // Cuota mensual, obligatorio y numérico
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
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
