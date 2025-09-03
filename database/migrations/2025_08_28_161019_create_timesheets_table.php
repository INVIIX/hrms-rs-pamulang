<?php

use App\Models\Employee;
use App\Models\WorkSchedule;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkSchedule::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignIdFor(Employee::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('work_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('shift_name')->nullable();
            $table->integer('break_duration')->default(0);
            $table->boolean('is_overnight')->default(false);
            $table->boolean('is_holiday')->default(false);
            $table->boolean('geolocation_required')->default(false);
            $table->string('location_name')->nullable();
            $table->string('location_lat')->nullable();
            $table->string('location_lng')->nullable();
            $table->integer('location_radius')->default(50);
            $table->datetime('clock_in')->nullable();
            $table->string('clock_in_lat')->nullable();
            $table->string('clock_in_lng')->nullable();
            $table->string('clock_in_image')->nullable();
            $table->datetime('clock_out')->nullable();
            $table->string('clock_out_lat')->nullable();
            $table->string('clock_out_lng')->nullable();
            $table->string('clock_out_image')->nullable();
            $table->enum('status', ['present', 'late', 'absent', 'leave']);
            $table->longText('notes')->nullable();
            $table->foreignIdFor(Employee::class, "verified_by")
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
