<?php

namespace App\UseCase;

use App\Repositories\ApiTaskParams;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ChildTaskUseCase
{
    public function __construct(
        private ChildTaskRepositoryInterface $childTaskRepository,
    ) {
    }


    /**
     * Undocumented function
     *
     * @param int $projectId
     * @param ApiTaskParams $params
     * @return Collection
     */
    public function fetchChildTasks(int $projectId, ApiTaskParams $params): Collection
    {
        return $this->childTaskRepository->searchChildTasksByParameters($projectId, $params);
    }

    /**
     * 子タスクstatus更新
     *
     * @param integer $childTaskId
     * @return void
     */
    public function updateChildTaskStatus(int $childTaskId, string $status): void
    {
        $status = ['status' => $status];
        $this->childTaskRepository->update($childTaskId, $status);
    }
}
