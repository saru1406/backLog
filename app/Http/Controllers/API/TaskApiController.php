<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchApiGantRequest;
use App\Http\Requests\FetchApiTaskRequest;
use App\Models\Project;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TaskApiController extends Controller
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function fetchTasks(FetchApiTaskRequest $request, Project $project)
    {
        $tasks = $this->taskRepository->searchTasksByParameters(
            $project->id,
            $request->getParams()
        );

        Log::info("タスク数". $tasks->count());
        return response()->json($tasks);
    }

    public function fetchGant(FetchApiGantRequest $request, Project $project)
    {
        $tasks = $this->taskRepository->gantTasksByParameters(
            $project->id,
            $request->getParams()
        );

        // Log::info("タスク数". $tasks->count());
        $task = response()->json($tasks);
        // Log::info("タスク",['task' => $task]);
        return $task;
    }
}
