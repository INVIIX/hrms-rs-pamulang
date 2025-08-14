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
        Schema::create('employee_educational_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('degree');                 // Contoh: S1, S2, Diploma
            $table->string('major')->nullable();      // Jurusan, optional
            $table->string('institution_name');       // Nama institusi
            $table->year('enrollment_year');          // Tahun angkatan / masuk
            $table->year('graduation_year')->nullable(); // Tahun lulus
            $table->decimal('gpa', 3, 2)->nullable();  // IPK/Grade Point Average (opsional), contoh: 3.75
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_educational_backgrounds');
    }
};
