<?php

namespace App\Services;

use App\Models\ChildTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ChildTaskParams;

interface ChildTaskServiceInterface
{
    /**
     * 子タスク保存
     *
     * @param integer $projectId
     * @param integer $taskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function storeChildTask(int $projectId, int $taskId, ChildTaskParams $params): void;

    /**
     * 子タスク更新
     *
     * @param integer $childTaskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function updateChildTask(int $childTaskId, ChildTaskParams $params): void;

    /**
     * 子タスクに紐づくユーザを取得
     *
     * @param ChildTask $childTask
     * @return User
     */
    public function getChildTasksByUser(ChildTask $childTask): User;

    /**
     * GPT自動子タスク生成
     *
     * @param string $taskTitle
     * @param string $taskContent
     * @return array
     */
    public function createChildTaskByGpt(string $taskTitle, string $taskContent): array;

    /**
     * GPT自動タスク生成データを保存
     *
     * @param Project $project
     * @param Task $task
     * @param array $childTasks
     * @return void
     */
    public function storeChildTasksByGpt(Project $project, Task $task, array $childTasks): void;
}
