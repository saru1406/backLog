<?php

namespace App\Repositories;

interface GptRepositoryInterface
{
    /**
     * GPTAPIで子タスクテキスト生成
     *
     * @param string $message
     * @return string
     */
    public function createChildTasks(string $message): string;
}
