<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeEmploymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'line_manager_id' => 'nullable|exists:employees,id',
            'position_id' => 'required|exists:positions,id',
            'group_id' => 'required|exists:groups,id',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'location' => 'string|max:255',
            'contract_document_number' => 'string|max:255',
            'employment_document_number' => 'string|max:255',
            'notes' => 'string',
        ];
    }
}
