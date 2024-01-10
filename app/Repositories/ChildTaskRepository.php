<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\Task;
use App\Repositories\ChildTaskRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ChildTaskRepository implements ChildTaskRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function store(array $params): ChildTask
    {
        return ChildTask::create($params);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchChildTasksByTaskId(Task $task, array $option = []): Collection
    {
        return $task->childTasks()->with($option)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function findOrFail(int $childTaskId, array $option = []): ChildTask
    {
        return ChildTask::with($option)->findOrFail($childTaskId);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $childTaskId, array $params): void
    {
        ChildTask::findOrFail($childTaskId)->update($params);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $childTaskId): void
    {
        ChildTask::findOrFail($childTaskId)->delete();
    }

    public function searchChildTasksByParameters(int $projectId, ApiTaskParams $params): Collection
    {
        $query = ChildTask::query();
        $query->where('project_id', $projectId);

        if ($params->getUserId() !== null) {
            $query->where('user_id', $params->getUserId());
            Log::info('ユーザID', ['user_id' => $params->getUserId()]);
        }

        if (in_array($params->getStatus(), ['未対応', '処理中', '処理済み', '完了'])) {
            $query->where('status', $params->getStatus());
            Log::info('ステータス', ['status' => $params->getStatus()]);
        }

        if ($params->getStatus() === "完了以外") {
            $query->where('status', '!=', '完了');
            Log::info('完了以外だよ');
        }

        if ($params->getPriority() !== null) {
            $query->where('priority', $params->getPriority());
            Log::info('優先度', ['priority' => $params->getPriority()]);
        }

        return $query->with(['user', 'task.type'])->get();
    }
}
