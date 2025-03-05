<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="ModifyFeeRequest",
 * title="Modify Fee Request",
 * description="Request para modificar una cuota existente.",
 * required={"cif", "concept", "amount", "notes"},
 * @OA\Property(property="cif", type="string", description="CIF del cliente."),
 * @OA\Property(property="concept", type="string", description="Concepto de la cuota."),
 * @OA\Property(property="amount", type="number", format="float", description="Monto de la cuota."),
 * @OA\Property(property="notes", type="string", description="Notas adicionales.")
 * )
 */

class ModifyFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method assumes the user is authorized to modify the fee. 
     * It could be extended with custom authorization logic if necessary.
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
     * This method defines the validation rules for each field when modifying the fee.
     * Fields such as CIF, concept, amount, and notes are required and validated accordingly.
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
     * This method returns custom error messages for each validation rule,
     * ensuring that users receive clear feedback when validation fails.
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
