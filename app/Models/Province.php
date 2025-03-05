<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Province",
 * title="Province",
 * description="Modelo de provincia.",
 * @OA\Property(property="cod", type="integer", description="Código de la provincia."),
 * @OA\Property(property="nombre", type="string", description="Nombre de la provincia.")
 * )
 */
class Province extends Model
{
    public $timestamps = false;  // Desactivar los timestamps

    use HasFactory;

    protected $fillable = [
        'cod',      // Province code
        'nombre',   // Province name
    ];
}
