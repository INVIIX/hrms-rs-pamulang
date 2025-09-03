<?php

namespace App\Http\Requests;

use App\Enums\Relationship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EmployeeContactRequest extends FormRequest
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
            'name' => 'required|string',
            'relationship' => ['required', new Enum(Relationship::class)],
            'date_of_birth' => ['nullable', 'date_format:Y-m-d'],
            'occupation' => ['nullable'],
            'phone' => ['required'],
            'is_dependant' => ['required', 'boolean'],
            'is_emergency_contact' => ['required', 'boolean'],
        ];
    }
}
