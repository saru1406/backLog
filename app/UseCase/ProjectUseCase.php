<?php

namespace App\UseCase;

use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProjectUseCase
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * タスクをページネーションで取得
     *
     * @param int $projectId
     * @return Collection
     */
    public function fetchNewTasks(int $projectId): Paginator
    {
        $project = $this->projectRepository->findOrFail($projectId, ['tasks']);

        return $this->taskRepository->findOrFailByPaginate($project, ['user']);
    }
}
