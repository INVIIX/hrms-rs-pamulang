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
                ->restrictOnDelete();

            $table->foreignIdFor(Group::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();

            // Enum sesuai LoanType & LoanStatus
            $table->enum('loan_type', ['personal_loan', 'other']);
            $table->decimal('amount', 15, 2);

            $table->enum('status', ['Aktif', 'Pending', 'Selesai'])->default('Pending');
            $table->decimal('emi', 15, 2)->default(0);
            $table->decimal('outstanding', 15, 2)->default(0);
            $table->decimal('interest_rate', 15, 2)->default(0);
            $table->integer('tenure')->default(0);
            $table->decimal('payment_progress', 15, 2)->default(0);
            $table->string('purpose');
            $table->foreignIdFor(Employee::class, 'approved_by_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('applied_date');
            $table->date('approved_date') ->nullable();
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
