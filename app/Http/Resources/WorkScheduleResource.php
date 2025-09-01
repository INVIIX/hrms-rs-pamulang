<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkScheduleResource extends JsonResource
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
            'shift_name' => $this->shift_name,
            'location_name' => $this->location_name,
            'location_lat' => $this->location_lat,
            'location_lng' => $this->location_lng,
            'location_radius' => $this->location_radius,
            'geolocation_required' => $this->geolocation_required,
            'days' => WorkScheduleDayResource::collection($this->whenLoaded('days')),
            'today' => new WorkScheduleDayResource($this->whenLoaded('today'))
        ];
    }
}
