<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSocialAccount extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
        'provider_email',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
