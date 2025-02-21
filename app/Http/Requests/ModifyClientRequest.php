<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        return [
            'cif' => 'required|unique:clients,cif,' . $this->input('client'),
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{9}$/',
            'email' => 'required|email|unique:clients,email,' . $this->input('client'),
            'bank_account' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:3',
            'monthly_fee' => 'required|numeric|min:0',
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
