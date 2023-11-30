<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskParams;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskService implements TaskServiceInterface
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * {@inheritDoc}
     */
    public function storeTask(int $projectId, TaskParams $params): void
    {
        $this->taskRepository->storeTask($projectId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(Task $task): User
    {
        return $this->taskRepository->getUser($task);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildTasks(Task $task): Collection
    {
        return $this->taskRepository->getChildTasks($task);
    }

    /**
     * {@inheritDoc}
     */
    public function updateTask(int $taskId, TaskParams $params): void
    {
        $this->taskRepository->updateTask($taskId, $params);
    }
}
