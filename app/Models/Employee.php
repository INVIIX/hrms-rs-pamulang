<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use App\Enums\EmployeeType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'work_schedule_id',
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

    protected $appends = ['role'];
    protected $with = ['profile'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => EmployeeType::class,
            'status' => EmployeeStatus::class,
        ];
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function socialAccounts()
    {
        return $this->hasMany(EmployeeSocialAccount::class);
    }

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
        return $this->hasMany(EmployeeSalaryComponent::class, 'employee_id');
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(EmployeeTraining::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function single_document(string $name = 'ktp'): MorphOne
    {
        return $this->documents()->one()->ofMany([
            'id' => 'max'
        ], function (Builder $query) use ($name) {
            $query->where('collection', '=', $name);
        });
    }

    public function work_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }
}
