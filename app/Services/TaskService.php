<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\GptRepositoryInterface;
use App\Repositories\TaskParams;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private GptRepositoryInterface $gptRepository,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function storeTask(int $projectId, TaskParams $params): void
    {
        $this->taskRepository->storeTask($projectId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(Task $task): User
    {
        return $this->taskRepository->getUser($task);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildTasks(Task $task): Collection
    {
        return $this->taskRepository->getChildTasks($task);
    }

    /**
     * {@inheritDoc}
     */
    public function updateTask(int $taskId, TaskParams $params): void
    {
        $this->taskRepository->updateTask($taskId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function storeBranchTask(Task $task): void
    {
        $message = 'タスクID:' . $task->id . ' タスク名:' . $task->title . ' タスク説明:' . $task->content . '\n
            タスク名、タスク説明からブランチ名にタスクIDを含めて簡潔に作成してください。\n
            回答に補足説明は不要です。必ずブランチ名のみの回答をしてください。\n
            タスク内容を読み取って、バグタスクであればfix/から始まるブランチの作成、実装タスクであればfeature/から始まるブランチを作成してください。\n
            必ずfix/かfeature/のどちらか一つのブランチを作成すること\n
            作業概要は英語で表記すること。\n
            作業概要はmax15字以内に収めること。\n
            例) \n
            バグタスクの場合\n
            fix/' . $task->id . '-作業概要\n
            実装タスクの場合\n
            feature/' . $task->id . '-作業概要';

        $branchGptText = $this->gptRepository->createChildTasks($message);

        $this->taskRepository->storeBranchTask($task->id, $branchGptText);
    }
}
