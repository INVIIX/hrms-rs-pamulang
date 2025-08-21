<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEmploymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'line_manager' => new EmployeeResource($this->whenLoaded('line_manager')),
            'position' => new PositionResource($this->whenLoaded('position')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'contract_document_number' => $this->contract_document_number,
            'employment_document_number' => $this->employment_document_number,
            'type' => $this->type,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
