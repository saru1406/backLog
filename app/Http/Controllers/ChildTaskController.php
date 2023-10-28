<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildTaskRequest;
use App\Http\Requests\UpdateChildTaskRequest;
use App\Models\ChildTask;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskServiceInterface;
use Inertia\Inertia;

class ChildTaskController extends Controller
{

    public function __construct(
        private ChildTaskRepositoryInterface $childTaskRepository,
        private ProjectRepository $projectRepository,
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
        $projectUsers = $this->projectRepository->getUsers($project);

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
        // dd($request->getStartDate());
        $this->childTaskRepository->storeChildTask(
            $request->getUserId(),
            $project->id,
            $task->id,
            $request->getTitle(),
            $request->getContents(),
            $request->getStatus(),
            $request->getPriority(),
            $request->getStartDate(),
            $request->getEndDate(),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildTask $childTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildTask $childTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildTaskRequest $request, ChildTask $childTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildTask $childTask)
    {
        //
    }
}
