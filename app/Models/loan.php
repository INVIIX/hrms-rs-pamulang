<?php

namespace App\Models;

use App\Enums\LoanStatus;
use App\Enums\LoanType;
use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    //
    protected $fillable = [
        'employee_id',
        'group_id',
        'loan_type',
        'amount',
        'status',
        'emi',
        'outstanding',
        'applied_date',
        'purpose',
        'tenure',
        'interest_rate'
    ];

    protected function casts(): array
    {
        return [
            'loan_type' => LoanType::class,
            'status' => LoanStatus::class,
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(Employee::class);
    }
}
