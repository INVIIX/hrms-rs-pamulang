<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class WorkSchedule extends Model
{
    protected $fillable = ['shift_name', 'location_name', 'location_lat', 'location_lng', 'location_radius', 'geolocation_required'];

    public function days(): HasMany
    {
        return $this->hasMany(WorkScheduleDay::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function today(): HasOne
    {
        return $this->days()->one()->ofMany([
            'id' => 'max',
        ], function (Builder $query) {
            $query->where('day_of_week', '=', now()->dayOfWeekIso);
        });
    }
}
