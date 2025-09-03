<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
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
            'work_schedule' => new WorkScheduleResource($this->whenLoaded('work_schedule')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'work_date' => $this->work_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'shift_name' => $this->shift_name,
            'break_duration' => $this->break_duration,
            'is_overnight' => $this->is_overnight,
            'is_holiday' => $this->is_holiday,
            'geolocation_required' => $this->geolocation_required,
            'location_name' => $this->location_name,
            'location_lat' => $this->location_lat,
            'location_lng' => $this->location_lng,
            'location_radius' => $this->location_radius,
            'clock_in' => $this->clock_in,
            'clock_in_lat' => $this->clock_in_lat,
            'clock_in_lng' => $this->clock_in_lng,
            'clock_in_image' => $this->clock_in_image,
            'clock_out' => $this->clock_out,
            'clock_out_lat' => $this->clock_out_lat,
            'clock_out_lng' => $this->clock_out_lng,
            'clock_out_image' => $this->clock_out_image,
            'notes' => $this->notes,
            'verified_by' => $this->verified_by,
            'verified_at' => $this->verified_at
        ];
    }
}
