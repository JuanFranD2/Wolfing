<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Puedes colocar lógica de autorización si lo necesitas
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cif' => 'required|string',    // CIF obligatorio y de tipo string
            'concept' => 'required|string', // Concepto obligatorio y de tipo string
            'amount' => 'required|numeric', // Amount obligatorio y de tipo numérico
            'notes' => 'required|string',   // Notes obligatorio y de tipo string
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cif.required' => 'El CIF es obligatorio.',
            'cif.string' => 'El CIF debe ser una cadena de texto.',
            'concept.required' => 'El concepto es obligatorio.',
            'concept.string' => 'El concepto debe ser una cadena de texto.',
            'amount.required' => 'El importe es obligatorio.',
            'amount.numeric' => 'El importe debe ser un número.',
            'notes.required' => 'Las notas son obligatorias.',
            'notes.string' => 'Las notas deben ser una cadena de texto.',
        ];
    }
}
