<?php

declare(strict_types=1);

namespace App\Services;

interface CommentServiceInterface
{
    /**
     * タスクコメント保存
     *
     * @param int $taskId
     * @param string $comment
     * @return void
     */
    public function storeByTask(int $taskId, string $comment): void;

    /**
     * 子タスクコメント保存
     *
     * @param int $childTaskId
     * @param string $comment
     * @return void
     */
    public function storeByChildTask(int $childTaskId, string $comment): void;
}
