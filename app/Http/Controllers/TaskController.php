<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskServiceInterface;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(private TaskServiceInterface $taskService)
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
    public function create(Project $project)
    {
        $projectUsers = $project->users;

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
        $userId = Auth::id();
        // dd($request);
        // dd($project);
        $projectId = $project->id;
        $title = $request->getTitle();
        $content = $request->getContents();
        $status = $request->getStatus();
        $priority = $request->getPriority();
        $manager = $request->getManager();
        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();

        $this->taskService->storeTask(
            $userId,
            $projectId,
            $title,
            $content,
            $status,
            $priority,
            $manager,
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
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
