<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Task",
 * title="Task",
 * description="Modelo de tarea.",
 * @OA\Property(property="id", type="integer", description="ID de la tarea."),
 * @OA\Property(property="client", type="string", description="Nombre del cliente."),
 * @OA\Property(property="contact_person", type="string", description="Persona de contacto."),
 * @OA\Property(property="contact_email", type="string", description="Email de contacto."),
 * @OA\Property(property="contact_phone", type="string", description="Teléfono de contacto."),
 * @OA\Property(property="description", type="string", description="Descripción de la tarea."),
 * @OA\Property(property="address", type="string", description="Dirección."),
 * @OA\Property(property="city", type="string", description="Ciudad."),
 * @OA\Property(property="postal_code", type="string", description="Código postal."),
 * @OA\Property(property="province", type="integer", description="ID de la provincia."),
 * @OA\Property(property="assigned_operator", type="integer", description="ID del operador asignado."),
 * @OA\Property(property="status", type="string", description="Estado de la tarea."),
 * @OA\Property(property="realization_date", type="string", format="date-time", description="Fecha de realización."),
 * @OA\Property(property="previous_notes", type="string", description="Notas previas."),
 * @OA\Property(property="subsequent_notes", type="string", description="Notas posteriores."),
 * @OA\Property(property="summary_file", type="string", description="Ruta del archivo de resumen.")
 * )
 */
class Task extends Model
{
    use HasFactory;


    protected $table = 'tasks';

    protected $fillable = [
        'client',
        'contact_person',
        'contact_phone',
        'description',
        'contact_email',
        'address',
        'city',
        'postal_code',
        'province',
        'status',
        'assigned_operator',
        'realization_date',
        'previous_notes',
        'subsequent_notes',
        'summary_file',
    ];

    protected $casts = [
        'realization_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'assigned_operator');
    }

    public function prov()
    {
        return $this->belongsTo(Province::class, 'province', 'cod');  // 'province' es la columna en Task y 'cod' es la columna en Province
    }

    public function getRealizationDateAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : 'No realization date';
    }

    // En tu modelo Task
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'P' => 'bg-yellow-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center',
            'E' => 'bg-blue-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center',
            'R' => 'bg-green-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center',
            'C' => 'bg-purple-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center',
            'X' => 'bg-red-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center',
            default => 'bg-gray-500 text-white px-3 py-1 rounded-full text-sm flex items-center justify-center'
        };
    }


    public function getStatusDescriptionAttribute()
    {
        return match ($this->status) {
            'P' => 'Pending Approval',
            'E' => 'In Progress',
            'R' => 'Completed',
            'C' => 'Under Review',
            'X' => 'Cancelled',
            default => 'Unknown'
        };
    }
}
