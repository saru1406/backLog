<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskServiceInterface;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct(
        private TaskServiceInterface $taskService,
        private TaskRepositoryInterface $taskRepository,
        private ProjectRepository $projectRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $projectTasks = $this->projectRepository->getTasks($project);
        $projectUsers = $this->projectRepository->getUsers($project);

        return Inertia::render('Task/Index', [
            'project' => $project,
            'projectTasks' => $projectTasks,
            'projectUser' => $projectUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $projectUsers = $this->projectRepository->getUsers($project);

        return Inertia::render('Task/Create', [
            'project' => $project,
            'projectUsers' => $projectUsers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, StoreTaskRequest $request)
    {
        $projectId = $project->id;
        $userId = $request->getUserId();
        $title = $request->getTitle();
        $content = $request->getContents();
        $status = $request->getStatus();
        $priority = $request->getPriority();
        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();

        $this->taskService->storeTask(
            $userId,
            $projectId,
            $title,
            $content,
            $status,
            $priority,
            $startDate,
            $endDate
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        $projectUsers = $this->projectRepository->getUsers($project);
        return Inertia::render('Task/Edit', [
            'project' => $project,
            'projectUsers' => $projectUsers,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $projectId = $project->id;
        $taskId = $task->id;
        $userId = $request->getUserId();
        $title = $request->getTitle();
        $content = $request->getContents();
        $status = $request->getStatus();
        $priority = $request->getPriority();
        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();

        $this->taskRepository->updateTask(
            $userId,
            $taskId,
            $projectId,
            $title,
            $content,
            $status,
            $priority,
            $startDate,
            $endDate
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
