<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUser(Collection $projectUserIds): Collection
    {
        return User::whereNotIn('id', $projectUserIds)->get();
    }
}
