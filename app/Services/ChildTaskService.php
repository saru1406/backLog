<?php

namespace App\Services;

use App\Models\ChildTask;
use App\Repositories\ChildTaskParams;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\GptRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\ProjectTaskNumberRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ChildTaskService implements ChildTaskServiceInterface
{
    public function __construct(
        private ChildTaskRepositoryInterface $childTaskRepository,
        private GptRepositoryInterface $gptRepository,
        private TaskRepositoryInterface $taskRepository,
        private ProjectRepositoryInterface $projectRepository,
        private ProjectTaskNumberRepositoryInterface $projectTaskNumberRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataCreate($projectId, $taskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users']);
        $task = $this->taskRepository->findOrFail($taskId);

        return collect(['project' => $project, 'task' => $task]);
    }

    /**
     * {@inheritDoc}
     */
    public function store(int $projectId, int $taskId, ChildTaskParams $params): void
    {
        $task = $this->taskRepository->findOrFail($taskId);
        $paramsArray = array_merge($params->toArray(), [
            'project_id' => $projectId,
            'task_id' => $taskId,
            'creator_id' => Auth::id(),
            'type_id' => $task->type_id,
        ]);

        $childTask = $this->childTaskRepository->store($paramsArray);

        $this->storeProjectTaskNumber($projectId, $childTask);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataShow(int $projectId, int $taskId, int $childTaskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId);
        $task = $this->taskRepository->findOrFail($taskId, ['user', 'childTasks', 'childTasks.user']);
        $childTask = $this->childTaskRepository->findOrFail($childTaskId, ['user', 'creator']);

        return collect(['project'=> $project, 'task'=> $task, 'child_task'=> $childTask]);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataEdit(int $projectId, int $taskId, int $childTaskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users']);
        $task = $this->taskRepository->findOrFail($taskId, ['child_task']);
        $childTask = $this->childTaskRepository->findOrFail($childTaskId, ['user']);

        return collect(['project'=> $project, 'task'=> $task, 'child_task'=> $childTask]);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $childTaskId, ChildTaskParams $params): void
    {
        $this->childTaskRepository->update($childTaskId, $params->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function storeChildTaskByGpt(int $projectId, int $taskId): void
    {
        $task = $this->taskRepository->findOrFail($taskId);
        $userId = Auth::id();

        $message = '親タスク:' . $task->title . ' 親タスク説明:' . $task->content . '子タスクのタイトルと説明を箇条書きで生成してください。\n
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
        $childTaskArray = $this->parseTasks($childTasksGptText);

        foreach ($childTaskArray as $childTaskParams) {
            $params = [
                'user_id' => $userId,
                'creator_id' => $userId,
                'project_id' => $projectId,
                'task_id' => $taskId,
                'type_id' => $task->type_id,
                'title' => $childTaskParams['title'],
                'content' => $childTaskParams['content'],
                'status' => '未対応',
                'priority' => '中',
                'start_date' => null,
                'end_date' => null
            ];
            $childTask = $this->childTaskRepository->store($params);
            $this->storeProjectTaskNumber($projectId, $childTask);
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

    /**
     * ProjectTaskNumberに子タスクを保存
     *
     * @param int $projectId
     * @param ChildTask $childTask
     * @return void
     */
    private function storeProjectTaskNumber(int $projectId, ChildTask $childTask): void
    {
        $taskNumber = $this->projectTaskNumberRepository->fetchTaskNumberbyProjectId($projectId);
        $projectTaskNumberParams = [
            'project_id' => $projectId,
            'task_number' => $taskNumber->task_number + 1,
            'taskable_id' => $childTask->id,
            'taskable_type' => 'App\Models\ChildTask',
        ];

        $this->projectTaskNumberRepository->store($projectTaskNumberParams);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $childTaskId): void
    {
        $this->childTaskRepository->destroy($childTaskId);
    }
}
