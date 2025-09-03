<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @method void merge(array $data)
 * @method void input(string $key)
 * @method Employee user()
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class ClockOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $now = now();
        $input = [
            'clock_out' => $now->format('Y-m-d H:i:s')
        ];
        $this->merge($input);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'clock_out' => ['required', 'date'],
            'clock_out_lat' => ['nullable'],
            'clock_out_lng' => ['nullable'],
            'clock_out_image' => ['nullable', 'file', 'image'],
            'notes' => ['required', 'string'],
        ];
    }
}
