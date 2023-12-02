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
        $this->childTaskRepository->storeChildTask($projectId, $taskId, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function updateChildTask(int $childTaskId, ChildTaskParams $params): void
    {
        $this->childTaskRepository->updateChildTask($childTaskId, $params);
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
        $message = '親タスク:' . $taskTitle . ' 親タスク説明:' . $taskContent . '子タスクのタイトルと説明を箇条書きで生成してください。\n
            Laravelを使用して実装するための子タスクを箇条書きで生成してください。各子タスクには、タスクのタイトルと具体的な実装手順を含めてください。\n
            例）\n
            - 子タスク1: お気に入り機能のUIを作成する\n
                - お気に入りボタンを設置する\n
                - ユーザーがお気に入りボタンを押すと、お気に入りが登録される\n
            - 子タスク2: お気に入り情報をデータベースに保存する\n
                - ユーザーごとにお気に入り情報を保存するデータベースを設計する\n
                - お気に入り情報が更新された際にデータベースを更新する処理を実装する\n
            - 子タスク3: お気に入り一覧画面を作成する\n
                - ユーザーごとにお気に入り一覧を表示する画面を設計する\n
                - お気に入り一覧から選択したアイテムにアクセスできるようにリンクを作成する\n
            - 子タスク4: セキュリティ対策を行う\n
                - お気に入り情報をデータベースに保存する際にデータの暗号化を行う\n
                - ログイン状態を管理し、お気に入り情報にアクセスできるユーザーを制限する';

        $childTasksGptText = $this->gptRepository->createChildTasks($message);

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
