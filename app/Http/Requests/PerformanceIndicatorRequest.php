<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[] $attachment
 * @method \Illuminate\Routing\Route route(string $param = null)
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class PerformanceIndicatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'year' => ['required', 'numeric'],
            'attachment' => ['required', 'file']
        ];
    }
}
