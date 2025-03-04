<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Client model class.
 *
 * This class represents a client entity and provides methods to interact with
 * the `clients` table in the database. It includes fields like CIF, name, phone, 
 * email, bank account, country, currency, and monthly fee.
 */
class Client extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * This property defines the name of the database table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
        'name',
        'phone',
        'email',
        'bank_account',
        'country',
        'currency',
        'monthly_fee',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * This property can be used to hide sensitive or unnecessary attributes when 
     * the model is serialized into an array or JSON. In this case, there are no hidden attributes.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * This property defines the types to which certain attributes should be cast.
     * For example, the `monthly_fee` attribute is cast to a decimal with 2 decimal places.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monthly_fee' => 'decimal:2', // Casts the monthly_fee to a decimal with 2 decimal places
    ];
}
