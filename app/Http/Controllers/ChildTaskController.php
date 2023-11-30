<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildTaskRequest;
use App\Http\Requests\UpdateChildTaskRequest;
use App\Models\ChildTask;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Services\ChildTaskServiceInterface;
use App\Services\ProjectServiceInterface;
use App\Services\TaskServiceInterface;
use Inertia\Inertia;

class ChildTaskController extends Controller
{
    public function __construct(
        private ChildTaskRepositoryInterface $childTaskRepository,
        private ProjectServiceInterface $projectService,
        private TaskRepositoryInterface $taskRepository,
        private ChildTaskServiceInterface $childTaskService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, Task $task)
    {
        $projectUsers = $this->projectService->getUsers($project);

        return Inertia::render('ChildTask/Create', [
            'task' => $task,
            'project' => $project,
            'project_users' => $projectUsers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildTaskRequest $request, Project $project, Task $task)
    {
        $this->childTaskService->storeChildTask(
            $project->id,
            $task->id,
            $request->getParams()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task, ChildTask $childTask)
    {
        $childTaskUser = $this->childTaskRepository->getChildTasksByUser($childTask);
        $childTasks = $this->taskRepository->getChildTasks($task);

        return Inertia::render('ChildTask/Show', [
            'project' => $project,
            'task' => $task,
            'child_task_user' => $childTaskUser,
            'child_task' => $childTask,
            'child_tasks' => $childTasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task, ChildTask $childTask)
    {
        $projectUsers = $this->projectService->getUsers($project);
        $childTaskUser = $this->childTaskService->getChildTasksByUser($childTask);

        return Inertia::render('ChildTask/Edit', [
            'project' => $project,
            'project_users' => $projectUsers,
            'task' => $task,
            'child_task' => $childTask,
            'child_task_user' => $childTaskUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildTaskRequest $request, Project $project, Task $task, ChildTask $childTask)
    {
        $this->childTaskService->updateChildTask(
            $childTask->id,
            $request->getParams()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildTask $childTask)
    {
        //
    }

    public function storeGpt(Project $project, Task $task)
    {
        $childTasksArray = $this->childTaskService->createChildTaskByGpt($task->title, $task->content);
        $this->childTaskService->storeChildTasksByGpt($project, $task, $childTasksArray);
    }
}
