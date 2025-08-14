<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:32|unique:employees,name',
            'email' => 'required|email|max:64|unique:employees,email',
            'phone' => 'required|string|max:14|unique:employees,phone',
            'nip' => 'required|string|max:32|unique:employees,nip',
            'hire_date' => [
                'required',
                Rule::date()->format('Y-m-d')
            ],
            'type' => 'required|in:Permanent,Contract,Internship,Freelance,Temporary',
            'status' => 'required|in:Active,Probation,Resigned,Terminated,Retired',
            'avatar' => 'nullable|image',
            'password' => 'required|string|max:255',
            'profile.name' => 'required|string|max:255',
            'profile.nik' => 'required|string|max:16|unique:employee_profiles,nik',
            'profile.npwp' => 'nullable|string|max:15',
            'profile.bpjs_kesehatan' => 'nullable|string|max:13',
            'profile.bpjs_ketenagakerjaan' => 'nullable|string|max:11',
            'profile.place_of_birth' => 'required|string|max:64',
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
