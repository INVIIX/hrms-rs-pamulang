<?php

use App\Models\Employee;
use App\Models\Group;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // Relasi ke employees & departments
            $table->foreignIdFor(Employee::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Group::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();

            // Enum sesuai LoanType & LoanStatus
            $table->enum('loan_type', ['personal_loan', 'other']);
            $table->decimal('amount', 15, 2);

            $table->enum('status', ['aktif', 'pending', 'selesai'])->default('pending');
            $table->decimal('emi', 15, 2)->default(0);
            $table->decimal('outstanding', 15, 2)->default(0);

            $table->date('applied_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan');
    }
};
