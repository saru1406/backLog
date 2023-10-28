<?php

namespace App\Services;

use App\Repositories\ChildTaskRepositoryInterface;

class ChildTaskService implements ChildTaskServiceInterface
{
    public function __construct(private ChildTaskRepositoryInterface $childTaskRepository)
    {
    }

}
