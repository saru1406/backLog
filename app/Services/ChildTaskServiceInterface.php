<?php

namespace App\Services;

use App\Repositories\ChildTaskParams;
use Illuminate\Support\Collection;

interface ChildTaskServiceInterface
{
    /**
     * createに表示するデータを取得
     *
     * @param integer $projectId
     * @param integer $taskId
     * @return Collection
     */
    public function fetchViewDataCreate(int $projectId, int $taskId): Collection;

    /**
     * 子タスク保存
     *
     * @param integer $projectId
     * @param integer $taskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function store(int $projectId, int $taskId, ChildTaskParams $params): void;

    /**
     * showに表示するデータを取得
     *
     * @param integer $projectId
     * @param integer $taskId
     * @param integer $childTaskId
     * @return Collection
     */
    public function fetchViewDataShow(int $projectId, int $taskId, int $childTaskId): Collection;

    /**
     * editに表示するデータを取得
     *
     * @param integer $projectId
     * @param integer $taskId
     * @param integer $childTaskId
     * @return Collection
     */
    public function fetchViewDataEdit(int $projectId, int $taskId, int $childTaskId): Collection;

    /**
     * 子タスク更新
     *
     * @param integer $childTaskId
     * @param ChildTaskParams $params
     * @return void
     */
    public function update(int $childTaskId, ChildTaskParams $params): void;

    /**
     * GPT自動子タスク生成、保存
      *
      * @param integer $projectId
      * @param integer $taskId
      * @return array
      */
    public function storeChildTaskByGpt(int $projectId, int $taskId): void;

    /**
     * 子タスク削除
     *
     * @param integer $childTaskId
     * @return void
     */
    public function destroy(int $childTaskId): void;
}
