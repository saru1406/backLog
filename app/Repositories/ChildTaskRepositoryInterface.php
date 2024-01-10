<?php

namespace App\Repositories;

use App\Models\ChildTask;
use App\Models\Task;
use Illuminate\Support\Collection;

interface ChildTaskRepositoryInterface
{
    /**
     * 子タスク保存
     *
     * @param array $params
     * @return ChildTask
     */
    public function store(array $params): ChildTask;

    /**
     * 課題に紐づいている子タスク取得
     *
     * @param Task $task
     * @param array $option
     * @return Collection
     */
    public function fetchChildTasksByTaskId(Task $task, array $option = []): Collection;

    /**
     * 子タスク取得
     *
     * @param integer $childTaskId
     * @param array $option
     * @return ChildTask
     */
    public function findOrFail(int $childTaskId, array $option = []): ChildTask;

    /**
     * 子タスク更新
     *
     * @param int $childTaskId
     * @param array $params
     * @return void
     */
    public function update(int $childTaskId, array $params): void;

    /**
     * 子タスク削除
     *
     * @param integer $childTaskId
     * @return void
     */
    public function destroy(int $childTaskId): void;

    public function searchChildTasksByParameters(int $projectId, ApiTaskParams $params): Collection;


    /**
     * タスクIDから取得
     *
     * @param int $taskId
     * @param array $option
     * @return Collection
     */
    public function fetchByTaskId(int $taskId, array $option = []): Collection;
}
