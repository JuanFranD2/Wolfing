<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();

            // CIF (Código de Identificación Fiscal)
            $table->string('cif')->index();

            // Concept (description of the charge)
            $table->string('concept');

            // Issue Date
            $table->date('issue_date');

            // Amount
            $table->decimal('amount', 10, 2);

            // Passed (S/N) - Default 'N'
            $table->enum('passed', ['S', 'N'])->default('N');

            // Payment Date
            $table->date('payment_date')->nullable();

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
