<?php

namespace App\Models;

use App\Enums\Citizenship;
use App\Enums\Gender;
use App\Enums\MaritalStatus;
use App\Enums\Religion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'npwp',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'marital_status',
        'citizenship',
        'legal_address',
        'residential_address'
    ];

    protected $casts = [
        // 'date_of_birth' => 'datetime:Y-m-d',
        'gender' => Gender::class,
        'religion' => Religion::class,
        'marital_status' => MaritalStatus::class,
        'citizenship' => Citizenship::class,
    ];

    /**
     * Get the user that owns the EmployeeContact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
