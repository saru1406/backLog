<?php

namespace App\UseCase;

use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * タスクstatus更新
     *
     * @param integer $taskId
     * @return void
     */
    public function updateTaskStatus(int $taskId, string $status): void
    {
        $status = ['status' => $status];
        $this->taskRepository->update($taskId, $status);
    }
}
