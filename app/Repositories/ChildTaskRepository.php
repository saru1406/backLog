<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\User;
use App\Repositories\ChildTaskRepositoryInterface;
use Carbon\Carbon;

class ChildTaskRepository implements ChildTaskRepositoryInterface
{
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
    ): void {
        $startDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');

        ChildTask::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'task_id' => $taskId,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function getChildTasksByUser(ChildTask $childTasks): User
    {
        return $childTasks->user;
    }

    public function updateChildTask(
        int $childTaskId,
        int $userId,
        string $title,
        string $content,
        string $status,
        string $priority,
        ?string $startDate,
        ?string $endDate
    ): void {
        $startDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');

        ChildTask::where('id', $childTaskId)->update([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
