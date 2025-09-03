<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkScheduleDay extends Model
{
    protected $fillable = ['work_schedule_id', 'day_of_week', 'day_name', 'start_time', 'end_time', 'break_duration', 'is_overnight', 'is_holiday'];
    protected $casts = [
        'day_of_week' => DayOfWeek::class,
    ];

    #[Scope]
    protected function today(Builder $query): void
    {
        $query->where('day_of_week', '=', now()->dayOfWeekIso);
    }


    public function work_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }
}
