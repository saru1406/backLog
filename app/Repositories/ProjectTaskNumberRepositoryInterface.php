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
}
