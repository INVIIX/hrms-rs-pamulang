<?php

namespace App\Models;

use App\Enums\Degree;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducationalBackground extends Model
{
    protected $fillable = [
        "degree",
        "major",
        "institution_name",
        "enrollment_year",
        "graduation_year",
        "gpa"
    ];

    protected $casts = [
        'degree' => Degree::class
    ];
}
