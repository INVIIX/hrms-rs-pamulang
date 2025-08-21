<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "relationship" => $this->relationship,
            "date_of_birth" => $this->date_of_birth,
            "occupation" => $this->occupation,
            "phone" => $this->phone,
            "is_dependant" => (boolean) $this->is_dependant,
            "is_emergency_contact" => (boolean) $this->is_emergency_contact
        ];
    }
}
