<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="CompleteTaskRequest",
 * title="Complete Task Request",
 * description="Request para completar una tarea existente.",
 * required={"status", "subsequent_notes", "summary_file"},
 * @OA\Property(property="status", type="string", description="Estado de la tarea (C: Completada, X: Cancelada)."),
 * @OA\Property(property="subsequent_notes", type="string", description="Notas posteriores a la realización de la tarea."),
 * @OA\Property(property="summary_file", type="string", format="binary", description="Archivo de resumen de la tarea (PDF, máximo 10MB).")
 * )
 */
class CompleteTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method assumes the user is authorized by default but can be extended 
     * with custom logic if needed for task completion authorization.
     *
     * @return bool
     */
    public function authorize()
    {
        // Asumimos que el usuario está autorizado, pero podrías agregar lógica de autorización si es necesario.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the status, subsequent notes, 
     * and the summary file when completing a task.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|in:C,X',  // El estado debe ser uno de los valores válidos: Completed (C), Cancelled (X)
            'subsequent_notes' => 'required|string',  // Notas posteriores son obligatorias y deben ser de tipo string
            'summary_file' => 'required|file|mimes:pdf|max:10240',  // El archivo resumen es obligatorio, debe ser un PDF de máximo 10MB
        ];
    }

    /**
     * Get the custom error messages for validation.
     *
     * This method returns custom error messages for each validation rule, 
     * ensuring the user receives clear feedback when validation fails.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: Completed (C) or Cancelled (X).',  // Only C or X are valid
            'subsequent_notes.required' => 'The subsequent notes is required',
            'subsequent_notes.string' => 'The subsequent notes must be a string.',
            'summary_file.file' => 'The summary file must be a valid file.',
            'summary_file.mimes' => 'The summary file must be a PDF.',
            'summary_file.max' => 'The summary file must not exceed 10MB.',
        ];
    }
}
