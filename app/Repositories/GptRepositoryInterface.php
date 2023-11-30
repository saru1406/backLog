<?php

namespace App\Repositories;

interface GptRepositoryInterface
{
    /**
     * GPTAPIで子タスクテキスト生成
     *
     * @param string $taskTitle
     * @param string $taskContent
     * @return string
     */
    public function createChildTasks(string $taskTitle, string $taskContent): string;
}
