<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\HasCrudRepository;

class UserRepository
{
    use HasCrudRepository;
    public function __construct(protected User $model) {}
}
