<?php

namespace App\Repositories;

interface GptRepositoryInterface
{
    public function createChildTasks(string $taskTitle, string $taskContent);
}
