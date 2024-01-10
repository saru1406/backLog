<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\GptRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\ProjectTaskNumberRepositoryInterface;
use App\Repositories\TaskParams;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private GptRepositoryInterface $gptRepository,
        private ProjectServiceInterface $projectService,
        private ProjectRepositoryInterface $projectRepository,
        private ProjectTaskNumberRepositoryInterface $projectTaskNumberRepository,
        private ChildTaskRepositoryInterface $childTaskRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataIndex(int $projectId): Project
    {
        return $this->projectRepository->findOrFail($projectId, ['users', 'types']);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataCreate(int $projectId): Collection
    {
        $currentUser = Auth::user();
        $project = $this->projectRepository->findOrFail($projectId, ['users', 'types']);

        return collect(['current_user' => $currentUser, 'project' => $project]);
    }

    /**
     * {@inheritDoc}
     */
    public function store(int $projectId, TaskParams $params): void
    {
        $paramsArray = array_merge($params->toArray(), [
            'project_id' => $projectId,
            'creator_id' => Auth::id(),
        ]);

        $task = $this->taskRepository->store($paramsArray);

        $taskNumber = $this->projectTaskNumberRepository->fetchTaskNumberbyProjectId($projectId);
        if ($taskNumber) {
            $projectTaskNumberParams = [
                'project_id' => $projectId,
                'task_number' => $taskNumber->task_number + 1,
                'taskable_id' => $task->id,
                'taskable_type' => 'App\Models\Task',
            ];
        } else {
            $projectTaskNumberParams = [
                'project_id' => $projectId,
                'task_number' => 1,
                'taskable_id' => $task->id,
                'taskable_type' => 'App\Models\Task',
            ];
        }

        $this->projectTaskNumberRepository->store($projectTaskNumberParams);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataShow(int $projectId, int $taskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users', 'types']);
        // $task = $this->taskRepository->findOrFail($taskId, ['user', 'childTasks', 'childTasks.user', 'type', 'creator']);
        $task = $this->projectTaskNumberRepository->findOrFail($projectId, $taskId, ['taskable', 'taskable.user', 'taskable.type', 'taskable.creator']);
        if ($task->taskable_type === 'App\Models\Task') {
            $childTasks = $this->childTaskRepository->fetchByTaskId($task->taskable->id, ['user', 'type', 'creator', 'projectTaskNumber']);
            return collect(['project' => $project, 'task' => $task, 'childTasks' => $childTasks]);
        } else {
            $parentTask = $this->taskRepository->findOrFail($task->taskable->id, ['childTasks']);
            return collect(['project' => $project, 'task' => $parentTask, 'childTasks' => $task]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataEdit(int $projectId, int $taskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users', 'types']);
        $task = $this->taskRepository->findOrFail($taskId, ['user']);

        return collect(['project' => $project, 'task' => $task]);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $taskId, TaskParams $params): void
    {
        $this->taskRepository->update($taskId, $params->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function storeBranchTask(int $taskId): void
    {
        $task = $this->taskRepository->findOrFail($taskId, ['projectTaskNumbers']);
        dd($task->projectTaskNumbers->task_number);

        $message = 'タスクID:' . $task->projectTaskNumbers->task_number . ' タスク名:' . $task->title . ' タスク説明:' . $task->content . '\n
            タスク名、タスク説明からブランチ名にタスクIDを含めて簡潔に作成してください。\n
            回答に補足説明は不要です。必ずブランチ名のみの回答をしてください。\n
            タスク内容を読み取って、バグタスクであればfix/から始まるブランチの作成、実装タスクであればfeature/から始まるブランチを作成してください。\n
            必ずfix/かfeature/のどちらか一つのブランチを作成すること\n
            作業概要は英語で表記すること。\n
            作業概要はmax15字以内に収めること。\n
            例) \n
            バグタスクの場合\n
            fix/' . $task->projectTaskNumbers->task_number . '-作業概要\n
            実装タスクの場合\n
            feature/' . $task->projectTaskNumbers->task_number . '-作業概要';

        $branchGptText = $this->gptRepository->createChildTasks($message);

        $this->taskRepository->storeBranchTask($task->id, $branchGptText);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $taskId): void
    {
        $this->taskRepository->destroy($taskId);
    }
}
