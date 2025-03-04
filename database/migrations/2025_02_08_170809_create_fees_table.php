<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines the structure of the `fees` table, which stores information about 
     * financial charges, including details like the CIF (fiscal identification code), concept 
     * (description of the charge), issue date, amount, passed status, payment date, and notes.
     *
     * @return void
     */
    public function up(): void
    {
        // Create the 'fees' table
        Schema::create('fees', function (Blueprint $table) {
            $table->id(); // Auto-incremental ID field

            // CIF (Código de Identificación Fiscal)
            $table->string('cif')->index(); // Unique fiscal ID, indexed for better search performance

            // Concept (description of the charge)
            $table->string('concept'); // Description of the fee

            // Issue Date
            $table->date('issue_date'); // Date the fee was issued

            // Amount
            $table->decimal('amount', 10, 2); // Amount of the fee (10 digits, 2 decimals)

            // Passed (S/N) - Default 'N'
            $table->enum('passed', ['S', 'N'])->default('N'); // Status of the fee, 'S' for passed, 'N' for not passed (default)

            // Payment Date
            $table->date('payment_date')->nullable(); // Payment date (nullable)

            // Notes
            $table->text('notes')->nullable(); // Additional notes (nullable)

            // Timestamps
            $table->timestamps(); // Automatically adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'fees' table if it exists.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('fees'); // Drop the 'fees' table
    }
};
