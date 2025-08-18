<?php

namespace App\Models;

use App\Enums\SalaryComponentType;
use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description'
    ];

    protected function casts(): array
    {
        return [
            'type' => SalaryComponentType::class,
        ];
    }
}
