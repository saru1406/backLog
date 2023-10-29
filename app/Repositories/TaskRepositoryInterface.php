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
     * @param integer $userId
     * @param integer $projectId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
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
    ): void;

     /**
      * タスク検索
      *
      * @param integer $projectId
      * @param integer|null $userId
      * @param string|null $status
      * @param string|null $priority
      * @param integer|null $page
      * @return Paginator
      */
    public function searchTasksByParameters(
        int $projectId,
        ?int $userId,
        ?string $status,
        ?string $priority,
    ): Paginator;

    /**
     * 課題を更新
     *
     * @param integer $userId
     * @param integer $taskId
     * @param integer $projectId
     * @param string $title
     * @param string $content
     * @param string $status
     * @param string $priority
     * @param string|null $startDate
     * @param string|null $endDate
     * @return void
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
