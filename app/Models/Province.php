<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;  // Desactivar los timestamps
    use HasFactory;

    protected $fillable = [
        'cod',
        'nombre',
    ];
}
