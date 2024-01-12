<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }
}
