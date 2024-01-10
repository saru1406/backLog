<?php

namespace App\Repositories;

use App\Models\ProjectTaskNumber;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class ProjectTaskNumberRepository implements ProjectTaskNumberRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetchTaskNumberbyProjectId(int $projectId): ?ProjectTaskNumber
    {
        return ProjectTaskNumber::where('project_id', $projectId)->latest()->first();
    }

    /**
     * {@inheritDoc}
     */
    public function store(array $params): void
    {
        ProjectTaskNumber::create($params);
    }

    /**
     * {@inheritDoc}
     */
    public function findOrFail(int $projectId, int $taskId, array $option = []): ProjectTaskNumber
    {
        return ProjectTaskNumber::with($option)->where('project_id', $projectId)->where('task_number', $taskId)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function searchTasksByParameters(int $projectId, ApiTaskParams $params)
    {
        $query = ProjectTaskNumber::query();
        $query->where('project_id', $projectId)->with(['taskable', 'taskable.user', 'taskable.type']);

        if ($params->getUserId()) {
            $query->whereHas('taskable', function ($query) use ($params) {
                $query->where('user_id', $params->getUserId());
                Log::info('ユーザID', ['user_id' => $params->getUserId()]);
            });
        }

        if (in_array($params->getStatus(), ['未対応', '処理中', '処理済み', '完了'])) {
            $query->whereHas('taskable', function ($query) use ($params) {
                $query->where('status', $params->getStatus());
                Log::info('ステータス', ['status' => $params->getStatus()]);
            });
        }

        if ($params->getStatus() === "完了以外") {
            $query->whereHas('taskable', function ($query) {
                $query->where('status', '!=', '完了');
                Log::info('完了以外だよ');
            });
        }

        if ($params->getPriority()) {
            $query->whereHas('taskable', function ($query) use ($params) {
                $query->where('priority', $params->getPriority());
                Log::info('優先度', ['priority' => $params->getPriority()]);
            });
        }

        $query->orderBy('task_number', 'desc');
        Log::info('ページネーション', ['IsPagination' => $params->getIsPagination()]);
        return $query->paginate(20);
    }
}
