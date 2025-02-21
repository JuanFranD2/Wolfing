<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyOperUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Verifica si el usuario tiene permiso para realizar esta solicitud
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
            'email' => 'required|email|unique:users,email,' . $this->route('user'), // Excluye el correo del usuario actual
            'password' => 'nullable|string|min:8', // La contraseña es opcional y debe confirmarse si se establece
            'dni' => 'required|string|unique:users,dni,' . $this->route('user'), // Excluye el DNI del usuario actual
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'type' => 'in:oper,admin,client', // Asegura que el tipo sea uno de los permitidos
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
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.min' => 'The password must be at least 8 characters.',
            'dni.required' => 'The DNI field is required.',
            'dni.unique' => 'This DNI is already registered.',
            'phone.max' => 'The phone number cannot be longer than 20 characters.',
            'type.in' => 'Please select a valid type (oper, admin, or client).',
        ];
    }
}
