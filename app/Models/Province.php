<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Province model class.
 *
 * This class represents a province entity and provides methods to interact with 
 * the `provinces` table in the database. It includes fields like `cod` and `nombre`, 
 * which represent the province code and name, respectively.
 */
class Province extends Model
{
    public $timestamps = false;  // Desactivar los timestamps

    use HasFactory;

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
        'cod',    // Province code
        'nombre', // Province name
    ];
}
