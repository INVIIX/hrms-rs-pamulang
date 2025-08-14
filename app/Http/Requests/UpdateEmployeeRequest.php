<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method \Illuminate\Routing\Route route(string $param = null)
 */
class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        return [
            'name' => [
                'required',
                'string',
                'max:125',
                Rule::unique('employees')->ignore($employee)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee)
            ],
            'phone' => [
                'required',
                'string',
                Rule::unique('employees')->ignore($employee)
            ],
            'nip' => [
                'required',
                'string',
                Rule::unique('employees')->ignore($employee)
            ],
            'hire_date' => [
                Rule::date()->format('Y-m-d')
            ],
            'type' => 'nullable|in:Permanent,Contract,Internship,Freelance,Temporary',
            'status' => 'nullable|in:Active,Probation,Resigned,Terminated,Retired',
            'avatar' => 'nullable|image',
            'password' => 'nullable|string|max:255',
            'profile.name' => 'required|string|max:255',
            'profile.nik' => [
                'required',
                Rule::unique('employee_profiles', 'nik')->ignore($employee->profile->id)
            ],
            'profile.npwp' => 'nullable|string|max:255',
            'profile.bpjs_kesehatan' => 'nullable|string|max:255',
            'profile.bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'profile.place_of_birth' => 'required|string',
            'profile.date_of_birth' => [
                'required',
                Rule::date()->beforeOrEqual(today()->subYears(17))->format('Y-m-d')
            ],
            'profile.gender' => 'required|in:M,F',
            'profile.marital_status' => 'required|in:Belum Kawin,Kawin Belum Tercatat,Kawin Tercatat,Cerai Hidup,Cerai Mati',
            'profile.citizenship' => 'required|in:WNI,WNA',
            'profile.legal_address' => 'nullable|string',
            'profile.residential_address' => 'required|string',
        ];
    }
}
