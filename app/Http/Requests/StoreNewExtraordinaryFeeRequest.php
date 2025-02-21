<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewExtraordinaryFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Asume que todos los usuarios pueden realizar esta solicitud
        // Cambia esto si necesitas autorización adicional
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
            'cif' => 'required|exists:clients,cif', // El CIF debe existir en la tabla `clients`
            'concept' => 'required|string', // El concepto es requerido y debe ser un string
            'amount' => 'required|numeric', // El monto es requerido y debe ser un número
            'notes' => 'required|string', // Las notas son obligatorias y deben ser una cadena de texto
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cif.required' => 'The client CIF is required.',
            'cif.exists' => 'The specified CIF does not exist in our records.',
            'concept.required' => 'The concept is required.',
            'concept.string' => 'The concept must be a valid string.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'notes.required' => 'Notes are required.',
            'notes.string' => 'The notes must be a valid string.',
        ];
    }
}
