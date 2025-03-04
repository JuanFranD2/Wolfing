<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class to validate storing an operational user.
 *
 * This request handles the validation logic for creating a new operational user,
 * including fields such as name, email, password, DNI, phone, address, and type.
 */
class StoreOperUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method returns true, indicating that all users are authorized to 
     * store an operational user. You can add custom authorization logic if needed.
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
     * This method defines the validation rules for each field when storing 
     * a new operational user, including validation for required fields, 
     * uniqueness, and the type of user.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',  // Name is required and should be a string
            'email' => 'required|email|unique:users,email',  // Email is required, should be unique, and valid
            'password' => 'required|string|min:8',  // Password is required and should be at least 8 characters
            'dni' => 'required|string|max:9|unique:users,dni',  // DNI is required, should be unique, and have a max length of 9
            'phone' => 'required|string|max:15',  // Phone number is required and has a max length of 15
            'address' => 'required|string|max:255',  // Address is required and should be a string with a max length of 255
            'type' => 'required',  // User type is required and should be 'oper'
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * This method returns custom error messages for each validation rule,
     * providing the user with clear feedback when validation fails.
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
