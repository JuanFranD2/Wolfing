<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // CIF (Código de Identificación Fiscal)
            $table->string('cif')->unique();

            // Nombre
            $table->string('name');

            // Teléfono
            $table->string('phone')->nullable();

            // Correo
            $table->string('email')->unique();

            // Cuenta corriente
            $table->string('bank_account')->nullable();

            // País
            $table->string('country')->nullable();

            // Moneda
            $table->string('currency')->default('EUR');

            // Importe cuota mensual
            $table->decimal('monthly_fee', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
