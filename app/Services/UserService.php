<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function getProjectUser(): Collection
    {
        return $this->userRepository->getProjectUser();
    }
}
