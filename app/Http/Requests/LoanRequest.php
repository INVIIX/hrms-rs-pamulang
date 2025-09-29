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
            'employe_id'    => 'required|integer|exists:employees,id',
            'department_id' => 'required|integer|exists:departments,id',
            'loan_type'     => [new Enum(LoanType::class)],
            'amount'        => 'required|numeric',
            'status'        => [new Enum(LoanStatus::class)],
            'emi'           => 'nullable|numeric',
            'outstanding'   => 'nullable|numeric',
            'applied_date'  => 'required|date',
        ];
    }
}
