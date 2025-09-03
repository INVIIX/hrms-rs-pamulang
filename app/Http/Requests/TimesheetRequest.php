<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
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
            'work_schedule_id' => ['nullable'],
            'employee_id' => ['required', 'exists:employees,id'],
            'work_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i:s'],
            'end_time' => ['required', 'date_format:H:i:s'],
            'shift_name' => ['required', 'string'],
            'break_duration' => ['required', 'numeric'],
            'is_overnight' => ['required', 'boolean'],
            'is_holiday' => ['required', 'boolean'],
            'geolocation_required' => ['required', 'boolean'],
            'location_name' => ['nullable'],
            'location_lat' => ['nullable'],
            'location_lng' => ['nullable'],
            'location_radius' => ['nullable'],
            'clock_in' => ['required', 'date'],
            'clock_in_lat' => ['nullable'],
            'clock_in_lng' => ['nullable'],
            'clock_in_image' => ['nullable', 'file', 'image'],
            'clock_out' => ['required', 'date'],
            'clock_out_lat' => ['nullable'],
            'clock_out_lng' => ['nullable'],
            'clock_out_image' => ['nullable', 'file', 'image'],
            'notes' => ['required', 'string'],
            'verified_by' => ['nullable', 'exists:employees,id'],
            'verified_at' => ['nullable', 'date']
        ];
    }
}
