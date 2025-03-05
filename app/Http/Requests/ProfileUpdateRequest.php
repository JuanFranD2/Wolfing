<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 * schema="ProfileUpdateRequest",
 * title="Profile Update Request",
 * description="Request para actualizar el perfil del usuario.",
 * required={"name", "email"},
 * @OA\Property(property="name", type="string", description="Nombre del usuario."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario.")
 * )
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the user's profile update, 
     * including the required fields and rules for the email uniqueness, 
     * ignoring the currently authenticated user's email.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],  // Name is required, should be a string, and has a max length of 255
            'email' => [
                'required',
                'string',
                'lowercase',  // Ensures the email is in lowercase
                'email',  // Validates that the email is a proper email format
                'max:255',  // Max length for the email
                Rule::unique(User::class)->ignore($this->user()->id),  // Ensures the email is unique, but ignores the current user's email
            ],
        ];
    }
}
