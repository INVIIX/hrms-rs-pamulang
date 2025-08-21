<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use App\Enums\EmployeeType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'hire_date',
        'type',
        'status',
        'bank_name',
        'bank_account'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hire_date' => 'datetime:Y-m-d',
            'type' => EmployeeType::class,
            'status' => EmployeeStatus::class,
        ];
    }

    public function socialAccounts()
    {
        return $this->hasMany(EmployeeSocialAccount::class);
    }

    /**
     * Get the user associated with the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function employments(): HasMany
    {
        return $this->hasMany(EmployeeEmployment::class);
    }

    public function educational_backgrounds(): HasMany
    {
        return $this->hasMany(EmployeeEducationalBackground::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(EmployeeContact::class);
    }

    public function salary_components(): HasMany
    {
        return $this->hasMany(EmployeeSalaryComponent::class);
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(EmployeeTraining::class);
    }
}
