<?php

use App\Models\Employee;
use App\Models\Training;
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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nama pelatihan
            $table->text('description')->nullable();  // Deskripsi pelatihan
            $table->string('organizer')->nullable();  // Penyelenggara
            $table->string('location')->nullable();   // Lokasi pelatihan
            $table->integer('duration')->nullable();  // Durasi dalam jam atau hari
            $table->timestamps();
        });
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Training::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('training_date')->nullable();  // Tanggal pelaksanaan pelatihan
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->string('certificate')->nullable(); // Nama file atau path sertifikat
            $table->text('notes')->nullable();         // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_trainings');
        Schema::dropIfExists('trainings');
    }
};
