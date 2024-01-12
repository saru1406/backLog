<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
    public function index(int $projectId)
    {
        $project = $this->taskService->fetchViewDataIndex($projectId);

        return Inertia::render('Task/Index', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $projectId)
    {
        $data = $this->taskService->fetchViewDataCreate($projectId);

        return Inertia::render('Task/Create', [
            'project' => $data['project'],
            'currentUser' => $data['current_user'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $projectId, StoreTaskRequest $request)
    {
        $this->taskService->store($projectId, $request->getParams());

        return to_route('projects.tasks.create', $projectId);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $projectId, int $taskId)
    {
        $data = $this->taskService->fetchViewDataShow($projectId, $taskId);

        return Inertia::render('Task/Show', [
            'project' => $data['project'],
            'task' => $data['task'],
            'childTasks' => $data['task']['childTasks'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $projectId, int $taskId)
    {
        $data = $this->taskService->fetchViewDataEdit($projectId, $taskId);

        return Inertia::render('Task/Edit', [
            'project' => $data['project'],
            'task' => $data['task'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, int $projectId, int $taskId)
    {
        $this->taskService->update($taskId, $request->getParams());

        return to_route('projects.tasks.show', [$projectId, $taskId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $projectId, int $taskId)
    {
        $this->taskService->destroy($taskId);

        return to_route('projects.tasks.index', [$projectId]);
    }

    public function storeBranchGpt(int $projectId, int $taskId)
    {
        $this->taskService->storeBranchTask($taskId);
    }
}
