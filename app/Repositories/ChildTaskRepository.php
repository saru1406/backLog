<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\User;
use App\Repositories\ChildTaskRepositoryInterface;
use Carbon\Carbon;

class ChildTaskRepository implements ChildTaskRepositoryInterface
{
    public function storeChildTask(
        int $projectId,
        int $taskId,
        ChildTaskParams $params
    ): void {
        $startDate = Carbon::parse($params->getStartDate())->format('Y-m-d');
        $endDate = Carbon::parse($params->getEndDate())->format('Y-m-d');

        ChildTask::create([
            'user_id' => $params->getUserId(),
            'project_id' => $projectId,
            'task_id' => $taskId,
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
    public function getChildTasksByUser(ChildTask $childTasks): User
    {
        return $childTasks->user;
    }

    public function updateChildTask(int $childTaskId, ChildTaskParams $params): void
    {
        $startDate = Carbon::parse($params->getStartDate())->format('Y-m-d');
        $endDate = Carbon::parse($params->getEndDate())->format('Y-m-d');

        ChildTask::find($childTaskId)->update([
            'user_id' => $params->getUserId(),
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
