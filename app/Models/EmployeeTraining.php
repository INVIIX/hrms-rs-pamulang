<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeTraining extends Model
{
    protected $fillable = [
        'employee_id',
        'training_name',
        'training_start_date',
        'training_end_date',
        'certificate_name',
        'certificate_path',
        'notes'
    ];
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    
}
