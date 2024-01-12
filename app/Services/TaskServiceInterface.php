<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use App\Repositories\TaskParams;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    /**
     * indexに表示するデータ取得
     *
     * @param int $projectId
     * @return Project
     */
    public function fetchViewDataIndex(int $projectId): Project;

    /**
     * createに表示するデータ取得
     *
     * @param int $projectId
     * @return Collection
     */
    public function fetchViewDataCreate(int $projectId): Collection;

    /**
     * タスク保存
     *
     * @param int $projectId
     * @param TaskParams $params
     * @return void
     */
    public function store(int $projectId, TaskParams $params): void;

    /**
     * showに表示するデータ取得
     *
     * @param int $projectId
     * @param int $taskId
     * @return Collection
     */
    public function fetchViewDataShow(int $projectId, int $taskId): Collection;

    /**
     * editに表示するデータ取得
     *
     * @param int $projectId
     * @param int $taskId
     * @return Collection
     */
    public function fetchViewDataEdit(int $projectId, int $taskId): Collection;

    /**
     * タスク更新
     *
     * @param int $taskId
     * @param TaskParams $params
     * @return void
     */
    public function update(int $taskId, TaskParams $params): void;

    /**
     * ブランチ作成、保存
     *
     * @param int $taskId
     * @return void
     */
    public function storeBranchTask(int $taskId): void;

    /**
     * タスク削除
     *
     * @param int $taskId
     * @return void
     */
    public function destroy(int $taskId): void;
}
