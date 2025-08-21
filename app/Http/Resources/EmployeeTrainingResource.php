<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTrainingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'training_name' => $this->training_name,
            'training_start_date' => $this->training_start_date,
            'training_end_date' => $this->training_end_date,
            'certificate_name' => $this->certificate_name,
            'certificate_path' => $this->certificate_path,
            'certificate_url' => $this->certificate_url,
            'notes' => $this->notes,
        ];
    }
}
