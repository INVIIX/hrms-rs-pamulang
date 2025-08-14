<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEducationalBackgroundResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'employee_id' => $this->employee_id,
            'degree' => $this->degree,
            'major' => $this->major,
            'institution_name' => $this->institution_name,
            'enrollment_year' => $this->enrollment_year,
            'graduation_year' => $this->graduation_year,
            'gpa' => $this->gpa,
        ];
    }
}
