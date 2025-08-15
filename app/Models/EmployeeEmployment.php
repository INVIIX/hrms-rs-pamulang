<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEmployment extends Model
{
    protected $fillable = [
        'employee_id',
        'line_manager_id',
        'position_id',
        'group_id',
        'start_date',
        'end_date',
        'location',
        'contract_document_number',
        'employment_document_number',
        'notes'
    ];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d'
    ];

    /**
     * Get the user that owns the EmployeeEmployment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function line_manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'line_manager_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
