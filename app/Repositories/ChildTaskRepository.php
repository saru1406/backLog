<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Repositories\ChildTaskRepositoryInterface;
use Carbon\Carbon;

class ChildTaskRepository implements ChildTaskRepositoryInterface
{
    public function storeChildTask(
        ?int $userId,
        int $projectId,
        int $taskId,
        string $title,
        string $content,
        string $status,
        string $priority,
        ?string $startDate,
        ?string $endDate
    ): void {
        // dd($startDate);
        $startDate = Carbon::parse($startDate)->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->format('Y-m-d');
        // dd($startDate);
        // dd($endDate);
        ChildTask::create([
            "user_id" => $userId,
            "project_id" => $projectId,
            "task_id" => $taskId,
            "title" => $title,
            "content" => $content,
            "status" => $status,
            "priority" => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
