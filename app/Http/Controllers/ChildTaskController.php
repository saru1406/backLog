<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildTaskRequest;
use App\Http\Requests\UpdateChildTaskRequest;
use App\Services\ChildTaskServiceInterface;
use Inertia\Inertia;

class ChildTaskController extends Controller
{
    public function __construct(private ChildTaskServiceInterface $childTaskService)
    {
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
    public function create(int $projectId, int $taskId)
    {
        $data = $this->childTaskService->fetchViewDataCreate($projectId, $taskId);

        return Inertia::render('ChildTask/Create', [
            'task' => $data['task'],
            'project' => $data['project'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildTaskRequest $request, int $projectId, int $taskId)
    {
        $this->childTaskService->store($projectId, $taskId, $request->getParams());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $projectId, int $taskId, int $childTaskId)
    {
        $data = $this->childTaskService->fetchViewDataShow($projectId, $taskId, $childTaskId);

        return Inertia::render('ChildTask/Show', [
            'project' => $data['project'],
            'task' => $data['task'],
            'childTask' => $data['child_task'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $projectId, int $taskId, int $childTaskId)
    {
        $data = $this->childTaskService->fetchViewDataEdit($projectId, $taskId, $childTaskId);

        return Inertia::render('ChildTask/Edit', [
            'project' => $data['project'],
            'task' => $data['task'],
            'childTask' => $data['child_task'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildTaskRequest $request, int $childTaskId)
    {
        $this->childTaskService->update($childTaskId, $request->getParams());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $projectId, int $taskId, int $childTaskId)
    {
        $this->childTaskService->destroy($childTaskId);

        return to_route('projects.tasks.show', [$projectId, $taskId]);
    }

    public function storeChildTaskGpt(int $projecId, int $taskId)
    {
        $this->childTaskService->storeChildTaskByGpt($projecId, $taskId);
    }
}
