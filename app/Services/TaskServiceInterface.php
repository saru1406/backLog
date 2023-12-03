<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Type;
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

    /**
     * ブランチ作成、保存
     *
     * @param Task $task
     * @return void
     */
    public function storeBranchTask(Task $task): void;

    /**
     * タスクに紐づく種別取得
     *
     * @param Task $task
     * @return Type|null
     */
    public function fetchType(Task $task): ?Type;
}
