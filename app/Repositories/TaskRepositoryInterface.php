<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    /**
     * タスク取得
     *
     * @param integer $taskId
     * @param array $option
     * @return Task
     */
    public function findOrFail(int $taskId, array $option = []): Task;

    /**
     * タスクページネーションで取得
     *
     * @param Project $project
     * @param array $option
     * @param integer $perPage
     * @return Paginator
     */
    public function findOrFailByPaginate(Project $project, array $option = [], int $perPage = 10): Paginator;

    /**
     * タスク保存
     *
     * @param array $params
     * @return Task
     */
    public function store(array $params): Task;

    /**
     * タスク検索
     * @param integer $projectId
     * @param ApiTaskParams $params
     * @return Paginator|Collection
     */
    public function searchTasksByParameters(int $projectId, ApiTaskParams $params): Paginator|Collection;

    /**
     * ガント取得
     * @param integer $projectId
     * @param ApiGantParams $params
     * @return Collection
     */
    public function gantTasksByParameters(int $projectId, ApiGantParams $params): Collection;

    /**
     * 課題を更新
     *
     * @param integer $taskId
     * @param array $params
     * @return void
     */
    public function update(int $taskId, array $params): void;

    /**
     * タスクのブランチ名を保存
     *
     * @param int $taskId
     * @param string $BranchGptText
     * @return void
     */
    public function storeBranchTask(int $taskId, string $branchGptText) : void;

    /**
     * タスク削除
     *
     * @param integer $taskId
     * @return void
     */
    public function destroy(int $taskId): void;
}
