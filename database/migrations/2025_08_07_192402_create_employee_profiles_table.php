<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->unique()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('npwp')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->enum('religion', [
                'Islam',
                'Kristen',
                'Khatolik',
                'Hindu',
                'Budha',
                'Konghucu',
                'Kepercayaan'
            ]);
            $table->enum('marital_status', ['Belum Kawin', 'Kawin Belum Tercatat', 'Kawin Tercatat', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->enum('citizenship', ['WNI', 'WNA'])->default('WNI');
            $table->text('legal_address')->nullable();
            $table->text('residential_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
