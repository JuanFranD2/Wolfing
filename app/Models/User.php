<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User model class.
 *
 * This class represents a user entity and provides methods to interact with 
 * the `users` table in the database. It includes fields such as name, email, 
 * password, DNI, phone, address, and type. The class also uses authentication 
 * and notification features provided by Laravel.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * This property defines the attributes that can be mass assigned (i.e., 
     * those that can be filled directly via array input). It helps prevent mass 
     * assignment vulnerabilities by specifying which attributes are allowed to be 
     * assigned.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',         // Name of the user
        'email',        // Email address of the user
        'password',     // Password of the user
        'dni',          // DNI of the user
        'phone',        // Phone number of the user
        'address',      // Address of the user
        'type',         // Type of the user (admin, client, etc.)
        'created_at',   // Date the user was created
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * This property defines which attributes should be hidden when the model is 
     * serialized into an array or JSON. In this case, sensitive data like the 
     * password and remember token are hidden.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Hides the password field
        'remember_token', // Hides the remember token field
    ];

    /**
     * Get the attributes that should be cast.
     *
     * This method defines the casting of certain attributes. For instance, 
     * `email_verified_at` is cast to a datetime, and the `password` is cast 
     * to a hashed value.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Cast the email_verified_at to datetime
            'password' => 'hashed',             // Cast the password to a hashed value
        ];
    }
}
