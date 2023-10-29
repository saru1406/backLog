<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\User;

interface ChildTaskRepositoryInterface
{
    /**
     * 子タスク保存
     *
     * @param int $userId
     * @param int $projectId
     * @param int $taskId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
     */
    public function storeChildTask(
        int $userId,
        int $projectId,
        int $taskId,
        string $title,
        string $content,
        string $status,
        string $priority,
        ?string $startDate,
        ?string $endDate
    ): void;

    public function getChildTasksByUser(ChildTask $childTasks): User;
}
