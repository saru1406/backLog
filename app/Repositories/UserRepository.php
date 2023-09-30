<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     */
    public function getProjectNotUser(Collection $projectUserIds): Collection
    {
        return User::whereNotIn('id', $projectUserIds)->get();
    }
}
