<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
    public function searchTasksByParameters(
        int $projectId,
        int $userId = null,
        string $status = null,
        string $priority = null,
    ): Collection {
        $query = Task::query();
        $query->where('project_id', $projectId);

        if ($userId !== null) {
            $query->where('user_id', $userId);
            Log::info('user_id', ['user_id' => $userId]);
        }

        if (in_array($status, ['未対応', '処理中', '処理済み', '完了'])) {
            $query->where('status', $status);
            Log::info('status', ['status' => $status]);
        }

        if ($status === "完了以外") {
            $query->where('status', '!=', '完了');
            Log::info('完了以外だよ');
        }

        if ($priority !== null) {
            $query->where('priority', $priority);
            Log::info('priority', ['priority' => $priority]);
        }

        return $query->with('user')->get();
        ;
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
