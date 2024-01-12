<?php

namespace App\UseCase;

use App\Repositories\TaskRepositoryInterface;

class TaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * タスクstatus更新
     *
     * @param int $taskId
     * @return void
     */
    public function updateTaskStatus(int $taskId, string $status): void
    {
        $status = ['status' => $status];
        $this->taskRepository->update($taskId, $status);
    }
}
