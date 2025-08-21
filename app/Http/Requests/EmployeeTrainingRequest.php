<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[] $file
 * @method \Illuminate\Routing\Route route(string $param = null)
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class EmployeeTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'nullable|integer',
            'training_name' => 'string|max:255',
            'training_start_date' => 'date',
            'training_end_date' => 'date',
            'certificate_name' => 'string|max:255',
            'certificate_path' => 'string|max:255',
            'type' => 'string|in:Internal,External',
            'status' => 'string|in:Complete,Incomplete',
            'notes' => 'string',
        ];
    }
}
