<?php

namespace App\Repositories;

use App\Models\ProjectTaskNumber;

interface ProjectTaskNumberRepositoryInterface
{
    /**
     * プロジェクトに紐づくタスク番号を取得
     *
     * @param int $projectId
     * @return ProjectTaskNumber|null
     */
    public function fetchTaskNumberbyProjectId(int $projectId): ?ProjectTaskNumber;

    /**
     * ProjectTaskNumber保存
     *
     * @param array $params
     * @return void
     */
    public function store(array $params): void;

    /**
     * ProjectTaskNumber取得
     *
     * @param int $projectId
     * @param int $taskId
     * @param array $option
     * @return ProjectTaskNumber
     */
    public function findOrFail(int $projectId, int $taskId, array $option = []): ProjectTaskNumber;

    public function searchTasksByParameters(int $projectId, ApiTaskParams $params);
}
