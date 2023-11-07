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

    public function getChildTasksByUser(ChildTask $childTasks): User;

    /**
     * 子タスク更新
     *
     * @param integer $childTaskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function updateChildTask(
        int $childTaskId,
        ChildTaskParams $params
    ): void;
}
