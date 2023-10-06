<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
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
}
