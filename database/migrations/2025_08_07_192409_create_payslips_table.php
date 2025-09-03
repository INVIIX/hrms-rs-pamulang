<?php

use App\Models\Employee;
use App\Models\Payslip;
use App\Models\SalaryComponent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('net_pay', 15, 2)->default(0);
            $table->enum('status', ['draft', 'processed', 'paid'])->default('draft');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payslip_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payslip::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(SalaryComponent::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->enum('type', ['earning', 'deduction']);
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslip_items');
        Schema::dropIfExists('payslips');
    }
};
