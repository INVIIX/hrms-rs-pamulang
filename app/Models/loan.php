<?php

namespace App\Models;

use App\Enums\LoanStatus;
use App\Enums\LoanType;
use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    //
    protected $fillable = [
        'employe_id',
        'department_id',
        'loan_type',
        'amount',
        'status',
        'emi',
        'outstanding',
        'applied_date'
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
        return $this->belongsTo(Employee::class, 'employe_id');
    }

    public function department()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
