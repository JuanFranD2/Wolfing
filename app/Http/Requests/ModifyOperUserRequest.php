<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="ModifyOperUserRequest",
 * title="Modify Oper User Request",
 * description="Request para modificar un usuario operativo existente.",
 * required={"name", "email", "dni", "type"},
 * @OA\Property(property="name", type="string", description="Nombre del usuario."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario."),
 * @OA\Property(property="password", type="string", format="password", description="Contraseña del usuario (opcional)."),
 * @OA\Property(property="dni", type="string", description="DNI del usuario."),
 * @OA\Property(property="phone", type="string", description="Teléfono del usuario (opcional)."),
 * @OA\Property(property="address", type="string", description="Dirección del usuario (opcional)."),
 * @OA\Property(property="type", type="string", description="Tipo de usuario (oper, admin, client).")
 * )
 */
class ModifyOperUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to modify the operational user's data.
     * You can add custom authorization logic if necessary.
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
     * This method defines the validation rules for each field when modifying the operational user,
     * including exclusions for the current user's email and DNI.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',  // Name is required and should be a string
            'email' => 'required|email|unique:users,email,' . $this->route('user'), // Exclude current user's email
            'password' => 'nullable|string|min:8', // Password is optional but must be at least 8 characters if set
            'dni' => 'required|string|unique:users,dni,' . $this->route('user'), // Exclude current user's DNI
            'phone' => 'nullable|string|max:20',  // Phone is optional but should not exceed 20 characters
            'address' => 'nullable|string|max:255',  // Address is optional
            'type' => 'in:oper,admin,client',  // Ensure type is one of the allowed values: oper, admin, or client
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * This method returns custom error messages for each validation rule,
     * ensuring that the user receives clear feedback when validation fails.
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
