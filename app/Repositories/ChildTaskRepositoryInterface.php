<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\User;

interface ChildTaskRepositoryInterface
{
    /**
     * 子タスク保存
     *
     * @param int $projectId
     * @param int $taskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function storeChildTask(
        int $projectId,
        int $taskId,
        ChildTaskParams $params
    ): void;

    /**
     * 子タスクに紐づくユーザー取得
     *
     * @param ChildTask $childTasks
     * @return User
     */
    public function getChildTasksByUser(ChildTask $childTasks): User;

    /**
     * 子タスク更新
     *
     * @param int $childTaskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function updateChildTask(int $childTaskId, ChildTaskParams $params): void;

    /**
     * GPT生成データを保存
     *
     * @param int $projectId
     * @param int $taskId
     * @param int $userId
     * @param array $childTask
     * @return void
     */
    public function storeChildTaskByGpt(int $projectId, int $taskId, int $userId, array $childTask): void;
}
