<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Retorna true si el usuario está autorizado para realizar esta solicitud.
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'dni' => 'required|string|max:9|unique:users,dni',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'type' => 'required', // Asegura que el tipo sea 'oper'
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
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email must be unique.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'dni.required' => 'The DNI field is required.',
            'dni.unique' => 'The DNI must be unique.',
            'phone.required' => 'The phone field is required.',
            'address.required' => 'The address field is required.',
            'type.required' => 'The user type field is required.',
        ];
    }
}
