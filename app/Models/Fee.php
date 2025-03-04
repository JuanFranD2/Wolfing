<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Fee model class.
 *
 * This class represents a fee entity and provides methods to interact with 
 * the `fees` table in the database. It includes fields like CIF, concept, 
 * issue date, amount, passed status, payment date, and notes. 
 * The `client` relationship links the fee to a client via the CIF field.
 */
class Fee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * This property defines the name of the database table associated with the model.
     *
     * @var string
     */
    protected $table = 'fees';

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
        'cif',
        'concept',
        'issue_date',
        'amount',
        'passed',
        'payment_date',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This property defines the types to which certain attributes should be cast. 
     * For example, the `issue_date` and `payment_date` are cast to dates, 
     * and the `amount` is cast to a decimal with 2 decimal places.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date', // Casts the issue_date to a date
        'payment_date' => 'date', // Casts the payment_date to a date
        'amount' => 'decimal:2', // Casts the amount to a decimal with 2 decimal places
    ];

    /**
     * Define the relationship with the Client model.
     *
     * This method defines the inverse of the relationship between a fee and a client, 
     * where a fee belongs to a client. The relationship is based on the CIF field 
     * in both the `fees` and `clients` tables.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'cif', 'cif');
    }
}
