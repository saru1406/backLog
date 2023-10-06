<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * {@inheritDoc}
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
    ): void {
        $startDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');
        Task::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function findByUserId(int $userId, int $projectId): Collection
    {
        return Task::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->with('user')
            ->get();
    }

    /**
     * {@inheritDoc}
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
    ): void {
        $startDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');
        Task::where('id', $taskId)->update([
            'user_id' => $userId,
            'project_id' => $projectId,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
