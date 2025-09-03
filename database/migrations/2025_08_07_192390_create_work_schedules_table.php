<?php

use App\Models\WorkSchedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            $table->string('location_name')->nullable();
            $table->string('location_lat')->nullable();
            $table->string('location_lng')->nullable();
            $table->integer('location_radius')->default(50);
            $table->boolean('geolocation_required')->default(false);
            $table->timestamps();
        });

        Schema::create('work_schedule_days', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkSchedule::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('day_name', [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ]);
            $table->tinyInteger('day_of_week');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('break_duration')->default(0);
            $table->boolean('is_overnight')->default(false);
            $table->boolean('is_holiday')->default(false);
            $table->timestamps();
            $table->unique(['work_schedule_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedule_days');
        Schema::dropIfExists('work_schedules');
    }
};
