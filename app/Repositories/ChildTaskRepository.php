<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\Task;
use App\Repositories\ChildTaskRepositoryInterface;
use Illuminate\Support\Collection;

class ChildTaskRepository implements ChildTaskRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function store(array $params): void
    {
        ChildTask::create($params);
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
    public function storeChildTaskByGpt(int $projectId, int $taskId, int $userId, array $childTask): void
    {
        ChildTask::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'task_id' => $taskId,
            'title' => $childTask['title'],
            'content' => $childTask['content'],
            'status' => '未対応',
            'priority' => '中',
            'start_date' => null,
            'end_date' => null
        ]);
    }
}
