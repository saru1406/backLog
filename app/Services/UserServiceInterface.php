<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getProjectUser(): Collection;
}
