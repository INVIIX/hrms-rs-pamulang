<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkScheduleDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'work_schedule_id' => $this->work_schedule_id,
            'day_of_week' => $this->day_of_week,
            'day_name' => $this->day_of_week->label(),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'break_duration' => $this->break_duration,
            'is_overnight' => $this->is_overnight,
            'is_holiday' => $this->is_holiday
        ];
    }
}
