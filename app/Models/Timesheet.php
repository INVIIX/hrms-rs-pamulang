<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timesheet extends Model
{

    protected $with = ['employee'];
    protected $fillable = [
        'work_schedule_id',
        'employee_id',
        'work_date',
        'start_time',
        'end_time',
        'shift_name',
        'break_duration',
        'is_overnight',
        'is_holiday',
        'geolocation_required',
        'location_name',
        'location_lat',
        'location_lng',
        'location_radius',
        'clock_in',
        'clock_in_lat',
        'clock_in_lng',
        'clock_in_image',
        'clock_out',
        'clock_out_lat',
        'clock_out_lng',
        'clock_out_image',
        'status',
        'notes',
        'verified_by',
        'verified_at'
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function work_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }
}
