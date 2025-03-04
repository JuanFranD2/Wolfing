<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines the structure of the `tasks` table, which stores information about 
     * various tasks, including details about the client, contact person, task description, 
     * status, assigned operator, and related notes. Additionally, it stores metadata like 
     * the realization date and associated summary file.
     *
     * @return void
     */
    public function up(): void
    {
        // Create the 'tasks' table
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Auto-incremental ID field

            // Client
            $table->string('client')->nullable(); // Client name (nullable)

            // Contact person
            $table->string('contact_person')->nullable(); // Contact person name (nullable)

            // Contact phone
            $table->string('contact_phone')->nullable(); // Contact phone (nullable)

            // Description
            $table->text('description')->nullable(); // Task description (nullable)

            // Contact email
            $table->string('contact_email')->nullable(); // Contact email (nullable)

            // Address
            $table->string('address')->nullable(); // Address of the task (nullable)

            // City
            $table->string('city')->nullable(); // City (nullable)

            // Postal code
            $table->string('postal_code', 10)->nullable(); // Postal code (nullable)

            // Province (INE code)
            $table->char('province', 2)->nullable(); // Province code (nullable)

            // Status (P=Pending, E=In process, R=Realized, C=Completed, X=Canceled)
            $table->enum('status', ['P', 'E', 'R', 'C', 'X'])->default('P'); // Default is 'P' (Pending)

            // Assigned operator
            $table->string('assigned_operator')->nullable(); // Assigned operator (nullable)

            // Task realization date
            $table->datetime('realization_date')->nullable(); // Realization date of the task (nullable)

            // Previous notes
            $table->text('previous_notes')->nullable(); // Previous notes related to the task (nullable)

            // Subsequent notes
            $table->text('subsequent_notes')->nullable(); // Subsequent notes related to the task (nullable)

            // Summary file
            $table->string('summary_file')->nullable(); // File containing the summary (nullable)

            // Timestamps
            $table->timestamps(); // Automatically adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'tasks' table if it exists.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks'); // Drop the 'tasks' table
    }
};
