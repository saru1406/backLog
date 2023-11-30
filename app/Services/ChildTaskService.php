<?php

namespace App\Services;

use App\Models\ChildTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ChildTaskParams;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\GptRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ChildTaskService implements ChildTaskServiceInterface
{
    public function __construct(
        private ChildTaskRepositoryInterface $childTaskRepository,
        private GptRepositoryInterface $gptRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function storeChildTask(int $projectId, int $taskId, ChildTaskParams $params): void
    {
        return $this->childTaskRepository->storeChildTask($projectId, $taskId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function updateChildTask(int $childTaskId, ChildTaskParams $params): void
    {
        return $this->childTaskRepository->updateChildTask($childTaskId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildTasksByUser(ChildTask $childTask): User
    {
        return $this->childTaskRepository->getChildTasksByUser($childTask);
    }

    /**
     * {@inheritDoc}
     */
    public function createChildTaskByGpt(string $taskTitle, string $taskContent): array
    {
        $childTasksGptText = $this->gptRepository->createChildTasks($taskTitle, $taskContent);
        return $this->parseTasks($childTasksGptText);
    }

    /**
     * {@inheritDoc}
     */
    public function storeChildTasksByGpt(Project $project, Task $task, array $childTasks): void
    {
        $userId = Auth::id();
        foreach ($childTasks as $childTask) {
            $this->childTaskRepository->storeChildTaskByGpt($project->id, $task->id, $userId, $childTask);
        }
    }

    /**
     * GPTテキスト出力を配列に加工
     *
     * @param string $text
     * @return array
     */
    private function parseTasks(string $text): array
    {
        $childTasks = [];
        $lines = explode("\n", $text);

        $currentTask = null;
        foreach ($lines as $line) {
            if (strpos($line, '- 子タスク') === 0) {
                if ($currentTask) {
                    // 現在のタスクの内容を一つの文字列に結合
                    $currentTask['content'] = implode(" ", $currentTask['content']);
                    // 前のタスクを配列に追加
                    $childTasks[] = $currentTask;
                }
                // 新しいタスクの開始
                $title = trim(substr($line, strpos($line, ':') + 1));
                $currentTask = ['title' => $title, 'content' => []];
            } elseif ($currentTask && preg_match('/^\s{2,}- /', $line)) {
                // タスクの説明を追加
                $currentTask['content'][] = trim(substr($line, strpos($line, '-') + 2));
            }
        }

        // 最後のタスクの内容も一つの文字列に結合し、配列に追加
        if ($currentTask) {
            $currentTask['content'] = implode(" ", $currentTask['content']);
            $childTasks[] = $currentTask;
        }

        return $childTasks;
    }
}
