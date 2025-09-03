<?php

namespace App\Http\Requests;

use App\Enums\DayOfWeek;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method void merge(array $data)
 * @method void input(string $key)
 */
class WorkScheduleRequest extends FormRequest
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
        $days = collect($this->input('days'))->map(function ($item) {
            $enum = DayOfWeek::tryFrom($item['day_of_week'] ?? null);
            $item['day_name'] = !empty($enum) ? $enum?->label() : 'Monday';
            return $item;
        })->toArray();

        $this->merge([
            'days' => $days,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shift_name' => ['required', 'string'],
            'location_name' => ['required', 'string'],
            'location_lat' => ['required_if:geolocation_required,true', 'numeric', 'between:-90,90'],
            'location_lng' => ['required_if:geolocation_required,true', 'numeric', 'between:-180,180'],
            'location_radius' => ['required_if:geolocation_required,true', 'numeric'],
            'geolocation_required' => ['boolean'],
            'days' => ['required', 'array', 'size:7'],
            'days.*.day_name' => ['required'],
            'days.*.day_of_week' => ['required', 'numeric', 'distinct', Rule::enum(DayOfWeek::class)],
            'days.*.start_time' => ['required', Rule::date()->format('H:i')],
            'days.*.end_time' => ['required', Rule::date()->format('H:i')],
            'days.*.break_duration' => ['required', 'numeric'],
            'days.*.is_overnight' => ['boolean'],
            'days.*.is_holiday' => ['boolean'],
        ];
    }
}
