<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\LoanType;
use App\Enums\LoanStatus;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id'    => 'required|integer|exists:employees,id',
            'group_id' => 'required|integer|exists:groups,id',
            'loan_type'     => [new Enum(LoanType::class)],
            'amount'        => 'required|numeric',
            'status'        => [new Enum(LoanStatus::class)],
            'emi'           => 'nullable|numeric',
            'outstanding'   => 'nullable|numeric',
            'purpose'   => 'required|string|max:255',
            'tenure'   => 'required|numeric',
            'interest_rate'   => 'nullable|numeric',
            'payment_progress'   => 'nullable|numeric',
            'approved_by_id'   => 'nullable|integer|exists:employees,id',
            'applied_date'  => 'required|date',
            'approved_date'  => 'nullable|date',
        ];
    }
}
