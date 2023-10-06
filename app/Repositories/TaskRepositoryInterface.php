<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
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
     * プロジェクトと担当者に紐づく課題を取得
     *
     * @param integer $managerId
     * @return void
     */
    public function findByUserId(int $userId, int $projectId): Collection;

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
}
