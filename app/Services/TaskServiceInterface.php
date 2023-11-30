<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskParams;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    /**
     * タスク保存
     *
     * @param integer $projectId
     * @param TaskParams $params
     * @return void
     */
    public function storeTask(int $projectId, TaskParams $params): void;

    /**
     * タスクに紐づくユーザ取得
     *
     * @param Task $task
     * @return User
     */
    public function getUser(Task $task): User;

    /**
     * タスクに紐づく子タスクを取得
     *
     * @param Task $task
     * @return Collection
     */
    public function getChildTasks(Task $task): Collection;

    /**
     * タスク更新
     *
     * @param integer $taskId
     * @param TaskParams $params
     * @return void
     */
    public function updateTask(int $taskId, TaskParams $params): void;
}
