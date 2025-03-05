<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="User",
 * title="User",
 * description="Modelo de usuario.",
 * @OA\Property(property="id", type="integer", description="ID del usuario."),
 * @OA\Property(property="name", type="string", description="Nombre del usuario."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario."),
 * @OA\Property(property="dni", type="string", description="DNI del usuario."),
 * @OA\Property(property="phone", type="string", description="Teléfono del usuario."),
 * @OA\Property(property="address", type="string", description="Dirección del usuario."),
 * @OA\Property(property="type", type="string", description="Tipo de usuario (admin, oper)."),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación del usuario.")
 * )
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'phone',
        'address',
        'type',
        'created_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
