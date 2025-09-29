<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'employee_id' => new EmployeeResource($this->whenLoaded('employee')),
            'group_id' => new GroupResource($this->whenLoaded('group')),
            'loan_type'    => $this->loan_type,
            'amount'       => $this->amount,
            'status'       => $this->status,
            'emi'          => $this->emi,
            'outstanding'  => $this->outstanding,
            'applied_date' => $this->applied_date,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
