<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getUser(Collection $projectUserIds): Collection;
}
