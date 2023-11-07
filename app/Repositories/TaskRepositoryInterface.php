<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    /**
     * タスク保存
     *
     * @param integer $projectId
     * @param TaskParams $params
     * @return void
     */
    public function storeTask(
        int $projectId,
        TaskParams $params
    ): void;

     /**
      * タスク検索
      *
      * @param integer $projectId
      * @param int|null $userId
      * @param string|null $status
      * @param string|null $priority
      * @param bool $isPagination
      * @return Paginator|Collection
      */
    public function searchTasksByParameters(
        int $projectId,
        ?int $userId,
        ?string $status,
        ?string $priority,
        bool $isPagination,
    ): Paginator|Collection;

    /**
     * 課題を更新
     *
     * @param integer $taskId
     * @param TaskParams $params
     * @return void
     */
    public function updateTask(
        int $taskId,
        TaskParams $params
    ): void;

    /**
     * 課題に紐づいているユーザを取得
     *
     * @param Task $task
     * @return User
     */
    public function getUser(Task $task): User;

    /**
     * 課題に紐づいているデータ取得
     *
     * @param Task $task
     * @return ChildTask
     */
    public function getTasksRelations(Task $task, array $relations): void;

    /**
     * 課題に紐づいている子タスク取得
     *
     * @param Task $task
     * @return ChildTask
     */
    public function getChildTasks(Task $task): Collection;
}
