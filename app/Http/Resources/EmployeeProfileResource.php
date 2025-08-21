<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nik' => $this->nik,
            'npwp' => $this->npwp,
            'bpjs_kesehatan' => $this->bpjs_kesehatan,
            'bpjs_ketenagakerjaan' => $this->bpjs_ketenagakerjaan,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'citizenship' => $this->citizenship,
            'legal_address' => $this->legal_address,
            'residential_address' => $this->residential_address,
        ];
    }
}
