<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchAPITaskRequest;
use App\Models\Project;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TaskApiController extends Controller
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function getTasksByUser(FetchAPITaskRequest $request, Project $project)
    {
        $tasks = $this->taskRepository->searchTasksByParameters(
            $project->id,
            $request->getUserId(),
            $request->getStatus(),
            $request->getPriority(),
        );
        Log::info($tasks);

        return response()->json($tasks);
    }
}
