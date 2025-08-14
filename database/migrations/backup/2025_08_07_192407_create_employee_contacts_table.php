<?php

use App\Models\Employee;
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
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('relationship');  // misal: spouse, child, friend, emergency_contact, guardian, etc
            $table->date('birth_date')->nullable();
            $table->string('occupation')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_dependent')->default(false);          // Apakah menjadi tanggungan karyawan?
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contacts');
    }
};
