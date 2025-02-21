<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ModifyTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'status.in' => 'The status must be required',
            'realization_date.date' => 'Please provide a valid realization date.',
            'realization_date.after_or_equal' => 'The realization date must be later than the creation date.',
            'previous_notes.string' => 'Previous notes must be a valid string.',
            'subsequent_notes.string' => 'Subsequent notes must be a valid string.',
            'summary_file.mimes' => 'The summary file must be a PDF.',
            'summary_file.max' => 'The summary file must not exceed 10 MB.',
        ];
    }
}
