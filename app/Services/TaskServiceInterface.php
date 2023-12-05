<?php

namespace App\Services;

use App\Repositories\TaskParams;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    /**
     * indexに表示するデータ取得
     *
     * @param integer $projectId
     * @return Collection
     */
    public function fetchViewDataIndex(int $projectId): Collection;

    /**
     * createに表示するデータ取得
     *
     * @param integer $projectId
     * @return Collection
     */
    public function fetchViewDataCreate(int $projectId): Collection;

    /**
     * タスク保存
     *
     * @param integer $projectId
     * @param TaskParams $params
     * @return void
     */
    public function store(int $projectId, TaskParams $params): void;

    /**
     * showに表示するデータ取得
     *
     * @param integer $projectId
     * @param integer $taskId
     * @return Collection
     */
    public function fetchViewDataShow(int $projectId, int $taskId): Collection;

    /**
     * editに表示するデータ取得
     *
     * @param integer $projectId
     * @param integer $taskId
     * @return Collection
     */
    public function fetchViewDataEdit(int $projectId, int $taskId): Collection;

    /**
     * タスク更新
     *
     * @param integer $taskId
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
}
