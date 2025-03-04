<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines the structure of the `users`, `password_reset_tokens`, and `sessions` tables.
     * The `users` table includes fields like name, email, password, DNI, phone, address, and type.
     * The `password_reset_tokens` table stores the reset token for password recovery.
     * The `sessions` table stores session data for authenticated users.
     *
     * @return void
     */
    public function up(): void
    {
        // Create the 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incremental ID field
            $table->string('name'); // User's name
            $table->string('email')->unique(); // Unique email field
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // User's password
            $table->string('dni')->unique(); // Unique DNI (Documento Nacional de Identidad) field
            $table->string('phone')->nullable(); // Phone number (nullable)
            $table->text('address')->nullable(); // User's address (nullable)
            $table->enum('type', ['admin', 'oper'])->default('oper'); // User type (default is 'oper')
            $table->rememberToken(); // Remember token for the user
            $table->timestamps(); // Created at and updated at timestamps
        });

        // Create the 'password_reset_tokens' table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email field, set as primary key
            $table->string('token'); // Reset token
            $table->timestamp('created_at')->nullable(); // Timestamp when the reset token was created
        });

        // Create the 'sessions' table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID
            $table->foreignId('user_id')->nullable()->index(); // Foreign key to the users table (nullable)
            $table->string('ip_address', 45)->nullable(); // IP address of the user (nullable)
            $table->text('user_agent')->nullable(); // User agent (nullable)
            $table->longText('payload'); // Session payload
            $table->integer('last_activity')->index(); // Last activity timestamp (indexed)
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the `users`, `password_reset_tokens`, and `sessions` tables if they exist.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop the 'users' table
        Schema::dropIfExists('password_reset_tokens'); // Drop the 'password_reset_tokens' table
        Schema::dropIfExists('sessions'); // Drop the 'sessions' table
    }
};
