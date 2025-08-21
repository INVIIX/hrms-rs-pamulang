<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeSalaryComponentBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'salary_components.*.employee_id' => 'nullable|integer',
            'salary_components.*.salary_component_id' => 'required|exists:salary_components,id',
            'salary_components.*.amount' => 'required|numeric',
        ];
    }
}
