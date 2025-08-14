<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeEducationalBackgroundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'degree' => 'string|in:Diploma,S1,S2,S3',
            'major' => 'string|max:125',
            'institution_name' => 'string|max:125',
            'enrollment_year' => 'required|date_format:Y',
            'graduation_year' => 'required|date_format:Y',
            'gpa' => 'numeric',
        ];
    }
}
