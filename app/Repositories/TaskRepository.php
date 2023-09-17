<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function storeTask(
        int $userId,
        string $title,
        string $content,
        string $status,
        string $priority,
        int $manager = null,
        string $startDate = null,
        string $endDate = null
    ): void {
        Task::create([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'priority' => $priority,
            'manager' => $manager,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
