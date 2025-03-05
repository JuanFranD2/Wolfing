<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Client",
 * title="Client",
 * description="Modelo de cliente.",
 * @OA\Property(property="id", type="integer", description="ID del cliente."),
 * @OA\Property(property="cif", type="string", description="CIF del cliente."),
 * @OA\Property(property="name", type="string", description="Nombre del cliente."),
 * @OA\Property(property="phone", type="string", description="Teléfono del cliente."),
 * @OA\Property(property="email", type="string", format="email", description="Correo electrónico del cliente."),
 * @OA\Property(property="bank_account", type="string", description="Cuenta bancaria del cliente."),
 * @OA\Property(property="country", type="string", description="País del cliente."),
 * @OA\Property(property="currency", type="string", description="Moneda del cliente."),
 * @OA\Property(property="monthly_fee", type="number", format="decimal", description="Cuota mensual del cliente.")
 * )
 */
class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

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

    protected $hidden = [];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
    ];
}
