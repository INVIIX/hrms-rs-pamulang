<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method void merge(array $data)
 * @method void input(string $key)
 * @method Employee user()
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class ClockInRequest extends FormRequest
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
        $employee = $this->user();//Employee::find($this->input('employee_id'));
        $input = [
            'work_schedule_id' => $employee->work_schedule_id,
            'employee_id' => $employee->id,
            'work_date' => $now->format('Y-m-d'),
            'start_time' => $employee->work_schedule->today->start_time,
            'end_time' => $employee->work_schedule->today->end_time,
            'shift_name' => $employee->work_schedule->shift_name,
            'break_duration' => $employee->work_schedule->today->break_duration,
            'is_overnight' => $employee->work_schedule->today->is_overnight,
            'is_holiday' => $employee->work_schedule->today->is_holiday,
            'geolocation_required' => $employee->work_schedule->geolocation_required,
            'location_name' => $employee->work_schedule->location_name,
            'location_lat' => $employee->work_schedule->location_lat,
            'location_lng' => $employee->work_schedule->location_lng,
            'location_radius' => $employee->work_schedule->location_radius,
            'clock_in' => $now->format('Y-m-d H:i:s')
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
        // until this
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
        ];
    }
}
