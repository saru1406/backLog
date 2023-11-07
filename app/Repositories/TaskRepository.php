<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function storeTask(
        int $projectId,
        TaskParams $params
    ): void {
        $startDate = Carbon::parse($params->getStartDate())->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($params->getEndDate())->format('Y-m-d H:i:s');
        Task::create([
            'user_id' => $params->getUserId(),
            'project_id' => $projectId,
            'title' => $params->getTitle(),
            'content' => $params->getContents(),
            'status' => $params->getStatus(),
            'priority' => $params->getPriority(),
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function searchTasksByParameters(
        int $projectId,
        ?int $userId,
        ?string $status,
        ?string $priority,
        bool $isPagination,
    ): Paginator|Collection {
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

        if ($isPagination) {
            return $query->with(['user', 'childTasks'])->paginate(20);
        }

        return $query->with(['user', 'childTasks'])->get();
    }

    /**
     * {@inheritDoc}
     */
    public function updateTask(
        int $taskId,
        TaskParams $params
    ): void {
        $startDate = Carbon::parse($params->getStartDate())->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($params->getEndDate())->format('Y-m-d H:i:s');
        Task::find('id', $taskId)->update([
            'user_id' => $params->getUserId(),
            'title' => $params->getTitle(),
            'content' => $params->getContents(),
            'status' => $params->getStatus(),
            'priority' => $params->getPriority(),
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function getUser(Task $task): User
    {
        return $task->user;
    }

    public function getTasksRelations(Task $task, array $relations): void
    {
        $task->load($relations);
    }

    public function getChildTasks(Task $task): Collection
    {
        return $task->childTasks()->with('user')->get();
    }
}
