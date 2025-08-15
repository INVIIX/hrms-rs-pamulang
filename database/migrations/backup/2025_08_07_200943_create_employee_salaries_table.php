<?php

use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\SalaryComponent;
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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->year('year');  // Tahun gaji
            $table->unsignedTinyInteger('month');  // Bulan gaji (1-12)
            $table->decimal('net_salary', 15, 2);  // Total gaji bersih setelah perhitungan
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_salary_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeSalary::class)->constrained();
            $table->foreignIdFor(SalaryComponent::class)->constrained();
            $table->decimal('amount', 15, 2);  // Nilai komponen gaji
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_details');
        Schema::dropIfExists('employee_salaries');
    }
};
