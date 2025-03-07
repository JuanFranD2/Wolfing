<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines the structure of the `clients` table, which stores information about
     * clients, including their CIF (fiscal identification code), name, contact information, 
     * bank account, country, currency, and monthly fee.
     *
     * @return void
     */
    public function up(): void
    {
        // Create the 'clients' table
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Auto-incremental ID field

            // CIF (Código de Identificación Fiscal)
            $table->string('cif')->unique(); // Unique CIF field, represents the fiscal ID of the client

            // Nombre
            $table->string('name'); // Client's name

            // Teléfono
            $table->string('phone')->nullable(); // Phone number of the client (nullable)

            // Correo
            $table->string('email')->unique(); // Client's email (unique)

            // Cuenta corriente
            $table->string('bank_account')->nullable(); // Client's bank account (nullable)

            // País
            $table->string('country')->nullable(); // Country of the client (nullable)

            // Moneda
            $table->string('currency')->default('eur'); // Currency used by the client (default is EUR)

            // Importe cuota mensual
            $table->decimal('monthly_fee', 10, 2)->default(0.00); // Monthly fee (default is 0.00)

            // Timestamps
            $table->timestamps(); // Automatically adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'clients' table if it exists.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('clients'); // Drop the 'clients' table
    }
};
