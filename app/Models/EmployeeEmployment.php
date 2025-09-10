<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        // 'start_date' => 'datetime:Y-m-d'
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
        return $this->belongsTo(Group::class);
    }

    protected function lineManagers(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {

                $employmentId = $attributes['id'];

                $managers = Employee::fromQuery("
                    WITH RECURSIVE managers AS (
                        SELECT em.employee_id, em.line_manager_id, 1 as level
                        FROM employee_employments em
                        WHERE em.id = ?

                        UNION ALL

                        SELECT em.employee_id, em.line_manager_id, m.level + 1
                        FROM employee_employments em
                        INNER JOIN managers m ON em.employee_id = m.line_manager_id
                    )
                    SELECT e.*, m.level
                    FROM managers m
                    JOIN employees e ON e.id = m.line_manager_id
                    ORDER BY m.level ASC
                ", [$employmentId]);

                $managers->load('profile');

                return $managers;
            }
        );
    }
}
