<?php

namespace App\Services;

use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\GptRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ChildTaskService implements ChildTaskServiceInterface
{
    public function __construct(private ChildTaskRepositoryInterface $childTaskRepository, private GptRepositoryInterface $gptRepository) {}


    public function createChildTaskByGpt(string $taskTitle, string $taskContent)
    {
        $childTasksGptText = $this->gptRepository->createChildTasks($taskTitle, $taskContent);
        // dd($this->parseTasks($childTasksGptText));
        return $this->parseTasks($childTasksGptText);
    }

    public function storeChildTasksByGpt($project, $task, $childTasks)
    {
        $userId = Auth::id();
        foreach ($childTasks as $childTask) {
            $this->childTaskRepository->storeChildTaskByGpt($project->id, $task->id, $userId, $childTask);
        }
    }

    private function parseTasks($text)
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
