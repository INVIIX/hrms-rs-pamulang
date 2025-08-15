<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'integer',
            'training_name' => 'string|max:255',
            'training_start_date' => 'date',
            'training_end_date' => 'date',
            'certificate_name' => 'string|max:255',
            'certificate_url' => 'string|max:255',
            'notes' => 'string',
        ];
    }
}
