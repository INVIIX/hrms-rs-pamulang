<?php

namespace App\Models;

use App\Enums\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeContact extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'relationship',
        'date_of_birth',
        'occupation',
        'phone',
        'is_dependent',
        'is_emergency_contact'
    ];
    protected $casts = [
        'relationship' => Relationship::class,
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
