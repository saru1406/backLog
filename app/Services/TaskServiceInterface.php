<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    /**
     * タスク保存
     *
     * @param int $userId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param integer|null $manager
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
     */
    public function storeTask(
        int $userId,
        string $title,
        string $content,
        string $status,
        string $priority,
        int $manager = null,
        string $startDate = null,
        string $endDate = null
    ): void;
}
