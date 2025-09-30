<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'loan_type'    => $this->loan_type,
            'amount'       => $this->amount,
            'status'       => $this->status,
            'emi'          => $this->emi,
            'outstanding'  => $this->outstanding,
            'purpose'  => $this->purpose,
            'tenure'  => $this->tenure,
            'interest_rate'  => $this->interest_rate,
            'payment_progress'  => $this->payment_progress,
            'approved_by_id'  => $this->approved_by_id,
            'applied_date' => $this->applied_date,
            'approved_date' => $this->applied_date,
        ];
    }
}
