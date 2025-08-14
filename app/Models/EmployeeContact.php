<?php

namespace App\Models;

use App\Enums\Relationship;
use Illuminate\Database\Eloquent\Model;

class EmployeeContact extends Model
{
    protected $casts = [
        'relationship' => Relationship::class,
    ];
}
