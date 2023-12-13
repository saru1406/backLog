<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\GptRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
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
        $paramsArray = $params->toArray();
        $paramsArray['project_id'] = $projectId;
        $paramsArray['creator_id'] = Auth::id();
        $this->taskRepository->store($paramsArray);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataShow(int $projectId, int $taskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users']);
        $task = $this->taskRepository->findOrFail($taskId, ['user', 'childTasks', 'childTasks.user', 'type']);

        return collect(['project' => $project, 'task'=> $task]);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataEdit(int $projectId, int $taskId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users', 'types']);
        $task = $this->taskRepository->findOrFail($taskId, ['user']);

        return collect(['project'=> $project, 'task'=> $task]);
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
        $task = $this->taskRepository->findOrFail($taskId);

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

    /**
     * {@inheritDoc}
     */
    public function destroy(int $taskId): void
    {
        $this->taskRepository->destroy($taskId);
    }
}
