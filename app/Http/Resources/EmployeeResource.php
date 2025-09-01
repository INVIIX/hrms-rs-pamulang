<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'nip' => $this->nip,
            'avatar' => $this->avatar,
            'type' => $this->type,
            'status' => $this->status,
            'bank_name' => $this->bank_name,
            'bank_account' => $this->bank_account,
            'hire_date' => $this->hire_date,
            'role' => $this->role,
            'profile' => new EmployeeProfileResource($this->whenLoaded('profile')),
            'work_schedule' => new WorkScheduleResource($this->whenLoaded('work_schedule')),
        ];
    }
}
