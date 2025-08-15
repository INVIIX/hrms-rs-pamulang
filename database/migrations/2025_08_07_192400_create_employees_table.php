<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->date('hire_date');
            $table->enum('type', ['Permanent', 'Full Time', 'Part Time', 'Contract', 'Internship', 'Freelance', 'Temporary']);
            $table->enum('status', ['Active', 'Probation', 'Resigned', 'Terminated', 'Retired']);
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
