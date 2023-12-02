<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\ProjectServiceInterface;
use App\Services\TaskServiceInterface;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct(
        private ProjectServiceInterface $projectService,
        private TaskServiceInterface $taskService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $projectUsers = $this->projectService->getProjectUsers($project);

        return Inertia::render('Task/Index', [
            'project' => $project,
            'project_users' => $projectUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $projectUsers = $this->projectService->getProjectUsers($project);

        return Inertia::render('Task/Create', [
            'project' => $project,
            'project_users' => $projectUsers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, StoreTaskRequest $request)
    {
        $this->taskService->storeTask($project->id, $request->getParams());
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        $taskUser = $this->taskService->getUser($task);
        $childTasks = $this->taskService->getChildTasks($task);

        return Inertia::render('Task/Show', [
            'project' => $project,
            'task' => $task,
            'task_user' => $taskUser,
            'child_tasks' => $childTasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        $projectUsers = $this->projectService->getUsers($project);

        return Inertia::render('Task/Edit', [
            'project' => $project,
            'project_users' => $projectUsers,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->taskService->updateTask($task->id, $request->getParams());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function storeBranchGpt(Project $project, Task $task)
    {
        $this->taskService->storeBranchTask($task);
    }
}
