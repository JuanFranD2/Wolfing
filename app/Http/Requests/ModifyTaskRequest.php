<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 * schema="ModifyTaskRequest",
 * title="Modify Task Request",
 * description="Request para modificar una tarea existente.",
 * required={"client", "contact_person", "contact_email", "contact_phone", "description", "address", "city", "postal_code", "province", "assigned_operator", "status"},
 * @OA\Property(property="client", type="string", description="Nombre del cliente."),
 * @OA\Property(property="contact_person", type="string", description="Persona de contacto."),
 * @OA\Property(property="contact_email", type="string", format="email", description="Correo electrónico de contacto."),
 * @OA\Property(property="contact_phone", type="string", description="Teléfono de contacto (9 dígitos)."),
 * @OA\Property(property="description", type="string", description="Descripción de la tarea."),
 * @OA\Property(property="address", type="string", description="Dirección."),
 * @OA\Property(property="city", type="string", description="Ciudad."),
 * @OA\Property(property="postal_code", type="string", description="Código postal (5 dígitos)."),
 * @OA\Property(property="province", type="string", description="Provincia."),
 * @OA\Property(property="assigned_operator", type="integer", description="ID del operador asignado."),
 * @OA\Property(property="status", type="string", description="Estado de la tarea (P, E, R, C, X)."),
 * @OA\Property(property="realization_date", type="string", format="date", description="Fecha de realización (opcional)."),
 * @OA\Property(property="previous_notes", type="string", description="Notas previas (opcional)."),
 * @OA\Property(property="subsequent_notes", type="string", description="Notas posteriores (opcional)."),
 * @OA\Property(property="summary_file", type="string", format="binary", description="Archivo de resumen (PDF, máximo 10MB, opcional).")
 * )
 */

class ModifyTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to modify the task. 
     * Custom authorization logic can be added if needed.
     *
     * @return bool
     */
    public function authorize()
    {
        // Verificar si el usuario está autorizado para modificar la tarea
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for each field when modifying a task,
     * including validation for task status, dates, and file uploads.
     * It also checks that the realization date is not earlier than the creation date.
     *
     * @return array
     */
    public function rules()
    {
        $taskId = $this->route('task');  // Obtiene el ID de la tarea actual

        // Obtener la tarea existente
        $task = \App\Models\Task::find($taskId);

        return [
            'client' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|digits:9', // Debe tener exactamente 9 dígitos
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|digits:5', // Debe tener exactamente 5 dígitos
            'province' => 'required|string', // Asegúrate de que el campo 'province' sea el correcto
            'assigned_operator' => 'required|exists:users,id', // Verifica que el operador exista
            'status' => 'required|in:P,E,R,C,X', // Estado debe ser uno de los valores válidos
            'realization_date' => [
                'nullable',
                function ($attribute, $value, $fail) use ($task) {
                    if ($value) {
                        // Convertir ambas fechas a formato Y-m-d sin la parte de la hora para compararlas
                        $realizationDate = date('Y-m-d', strtotime($value)); // Fecha introducida
                        $createdAtDate = date('Y-m-d', strtotime($task->created_at)); // Fecha de creación sin hora

                        // Comparar las fechas
                        if ($realizationDate < $createdAtDate) {
                            return $fail('The realization date must be equal to or after the creation date.');
                        }
                    }
                },
            ],
            'previous_notes' => 'nullable|string',
            'subsequent_notes' => 'nullable|string',
            'summary_file' => 'nullable|mimes:pdf|max:10240', // Máximo 10MB, solo PDF
        ];
    }

    /**
     * Get the custom attributes for the validation errors.
     *
     * This method defines custom attribute names for the validation error messages,
     * making them more user-friendly in the context of the task modification form.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'client' => 'Client',
            'contact_person' => 'Contact Person',
            'contact_email' => 'Contact Email',
            'contact_phone' => 'Contact Phone',
            'description' => 'Description',
            'address' => 'Address',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'province' => 'Province',
            'assigned_operator' => 'Assigned Operator',
            'status' => 'Status',
            'realization_date' => 'Realization Date',
            'previous_notes' => 'Previous Notes',
            'subsequent_notes' => 'Subsequent Notes',
            'summary_file' => 'Summary File',
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * This method returns custom error messages for each validation rule,
     * ensuring that users receive clear feedback when validation fails.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client.required' => 'The client field is required.',
            'contact_person.required' => 'The contact person field is required.',
            'contact_email.required' => 'The contact email field is required.',
            'contact_email.email' => 'Please provide a valid email address for the contact.',
            'contact_phone.required' => 'The contact phone number is required.',
            'contact_phone.digits' => 'The contact phone must be exactly 9 digits.',
            'description.required' => 'The description field is required.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'postal_code.required' => 'The postal code field is required.',
            'postal_code.digits' => 'The postal code must be exactly 5 digits.',
            'province.required' => 'Please select a province.',
            'assigned_operator.required' => 'You must assign an operator.',
            'assigned_operator.exists' => 'The selected operator is invalid.',
            'status.required' => 'Please select a valid task status.',
            'status.in' => 'The status must be required.',
            'realization_date.date' => 'Please provide a valid realization date.',
            'realization_date.after_or_equal' => 'The realization date must be later than the creation date.',
            'previous_notes.string' => 'Previous notes must be a valid string.',
            'subsequent_notes.string' => 'Subsequent notes must be a valid string.',
            'summary_file.mimes' => 'The summary file must be a PDF.',
            'summary_file.max' => 'The summary file must not exceed 10 MB.',
        ];
    }
}
