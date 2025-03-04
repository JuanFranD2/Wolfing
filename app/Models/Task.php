<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task model class.
 *
 * This class represents a task entity and provides methods to interact with 
 * the `tasks` table in the database. It includes fields such as client, contact person, 
 * description, contact information, address, status, and associated dates.
 * The class also defines relationships to the `User` model for the assigned operator 
 * and the `Province` model for the province.
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * This property defines the name of the database table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * This property defines the attributes that can be mass assigned (i.e., 
     * those that can be filled directly via array input). It helps prevent mass 
     * assignment vulnerabilities by specifying which attributes are allowed to be 
     * assigned.
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
     * This property defines the types to which certain attributes should be cast. 
     * For example, `realization_date`, `created_at`, and `updated_at` are cast 
     * to the respective date and datetime types.
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
     *
     * This method defines the relationship between a task and the operator assigned 
     * to it. A task belongs to a user (the operator).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'assigned_operator');
    }

    /**
     * Relationship to the Province model for the task's province.
     *
     * This method defines the relationship between a task and the province where 
     * it is located. A task belongs to a province, and the `province` column in 
     * the `tasks` table is linked to the `cod` column in the `provinces` table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prov()
    {
        return $this->belongsTo(Province::class, 'province', 'cod');  // 'province' es la columna en Task y 'cod' es la columna en Province
    }

    /**
     * Accessor to get the formatted realization date.
     *
     * This method formats the `realization_date` attribute to `Y-m-d H:i:s` if it's 
     * not null. If it's null, it returns the string "No realization date".
     *
     * @return string
     */
    public function getRealizationDateAttribute($value)
    {
        // Si 'realization_date' no es nulo, lo formateamos en 'Y-m-d H:i:s'
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : 'No realization date';
    }
}
