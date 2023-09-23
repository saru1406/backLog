<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getProjectUser(): Collection
    {
        return User::select('id', 'name')->get();
    }
}
