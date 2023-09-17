<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements TaskServiceInterface
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function storeTask(
        int $userId,
        string $title,
        string $content,
        string $status,
        string $priority,
        int $manager = null,
        string $startDate = null,
        string $endDate = null
    ): void {
        $this->taskRepository->storeTask(
            $userId,
            $title,
            $content,
            $status,
            $priority,
            $manager,
            $startDate,
            $endDate
        );
    }
}
