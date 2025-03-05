<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Fee",
 * title="Fee",
 * description="Modelo de cuota.",
 * @OA\Property(property="id", type="integer", description="ID de la cuota."),
 * @OA\Property(property="cif", type="string", description="CIF del cliente."),
 * @OA\Property(property="concept", type="string", description="Concepto de la cuota."),
 * @OA\Property(property="issue_date", type="string", format="date", description="Fecha de emisión de la cuota."),
 * @OA\Property(property="amount", type="number", format="decimal", description="Importe de la cuota."),
 * @OA\Property(property="passed", type="boolean", description="Indica si la cuota ha sido pasada."),
 * @OA\Property(property="payment_date", type="string", format="date", description="Fecha de pago de la cuota."),
 * @OA\Property(property="notes", type="string", description="Notas adicionales sobre la cuota.")
 * )
 */
class Fee extends Model
{
    use HasFactory;

    protected $table = 'fees';

    protected $fillable = [
        'cif',
        'concept',
        'issue_date',
        'amount',
        'passed',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cif', 'cif');
    }
}
