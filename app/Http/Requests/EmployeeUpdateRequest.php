<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[] $avatar
 * @method \Illuminate\Routing\Route route(string $param = null)
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class EmployeeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        $id = $employee->id ?? null;
        return [
            'name' => [
                'sometimes',
                'string',
                'max:125',
                Rule::unique('employees')->ignore($id)
            ],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('employees')->ignore($id)
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('employees')->ignore($id)
            ],
            'nip' => [
                'nullable',
                'string',
                Rule::unique('employees')->ignore($id)
            ],
            'hire_date' => [
                'nullable',
                Rule::date()->format('Y-m-d')
            ],
            'type' => 'nullable|in:Permanent,Contract,Internship,Freelance,Temporary',
            'status' => 'nullable|in:Active,Probation,Resigned,Terminated,Retired',
            'avatar' => 'nullable|file|image',
            'password' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin,super-admin',
            'work_schedule_id' => 'nullable|exists:work_schedules,id',
            'profile' => 'nullable|array',
            'profile.name' => 'nullable|string|max:255',
            'profile.nik' => [
                'nullable',
                Rule::unique('employee_profiles', 'nik')->ignore($id, 'employee_id')
            ],
            'profile.npwp' => [
                'nullable',
                Rule::unique('employee_profiles', 'npwp')->ignore($id, 'employee_id')
            ],
            'profile.bpjs_kesehatan' => 'nullable|string|max:255',
            'profile.bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'profile.place_of_birth' => 'nullable|string',
            'profile.date_of_birth' => [
                'nullable',
                Rule::date()->beforeOrEqual(today()->subYears(17))->format('Y-m-d')
            ],
            'profile.gender' => 'nullable|in:M,F',
            'profile.marital_status' => 'nullable|in:Belum Kawin,Kawin Belum Tercatat,Kawin Tercatat,Cerai Hidup,Cerai Mati',
            'profile.citizenship' => 'nullable|in:WNI,WNA',
            'profile.legal_address' => 'nullable|string',
            'profile.residential_address' => 'nullable|string',
        ];
    }
}
