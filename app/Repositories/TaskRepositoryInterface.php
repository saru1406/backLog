<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    /**
     * タスク保存
     *
     * @param integer $userId
     * @param integer $projectId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
     */
    public function storeTask(
        int $userId,
        int $projectId,
        string $title,
        string $content,
        string $status,
        string $priority,
        string $startDate = null,
        string $endDate = null
    ): void;

    /**
     * タスク検索
     *
     * @param integer $projectId
     * @param integer|null $userId
     * @param string|null $status
     * @param string|null $priority
     * @return Collection
     */
    public function searchTasksByParameters(
        int $projectId,
        int $userId = null,
        string $status = null,
        string $priority = null,
    ): Paginator;

    /**
     * 課題を更新
     *
     * @param integer $userId
     * @param integer $taskId
     * @param integer $projectId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
     */
    public function updateTask(
        int $userId,
        int $taskId,
        int $projectId,
        string $title,
        string $content,
        string $status,
        string $priority,
        string $startDate = null,
        string $endDate = null
    ): void;

    public function getUser(Task $task): User;
}
