<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|in:C,X',  // El estado debe ser uno de los valores válidos: Completed, Cancelled
            'subsequent_notes' => 'required|string',  // Notas posteriores son opcionales
            'summary_file' => 'required|file|mimes:pdf|max:10240',  // El archivo resumen es opcional, debe ser un PDF de máximo 10MB
        ];
    }

    /**
     * Get the custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: Completed (R) or Cancelled (X).',  // Ensures only C or X are valid
            'subsequent_notes.required' => 'The subsequent notes is required',
            'subsequent_notes.string' => 'The subsequent notes must be a string.',
            'summary_file.file' => 'The summary file must be a valid file.',
            'summary_file.mimes' => 'The summary file must be a PDF.',
            'summary_file.max' => 'The summary file must not exceed 10MB.',
        ];
    }
}
