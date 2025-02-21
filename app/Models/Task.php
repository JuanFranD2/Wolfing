<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'realization_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship to the User model for the assigned operator.
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'assigned_operator');
    }

    // Relación con la provincia
    public function prov()
    {
        return $this->belongsTo(Province::class, 'province', 'cod');  // 'province' es la columna en Task y 'cod' es la columna en Province
    }

    /**
     * Accesor para obtener la fecha de realización formateada.
     *
     * @return string
     */
    public function getRealizationDateAttribute($value)
    {
        // Si 'realization_date' no es nulo, lo formateamos en 'Y-m-d H:i:s'
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : 'No realization date';
    }
}
