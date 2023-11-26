<?php

namespace App\Services;

interface ChildTaskServiceInterface
{
    public function createChildTaskByGpt(string $taskTitle, string $taskContent);

    public function storeChildTasksByGpt($project, $task, $childTasks);
}
