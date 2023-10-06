<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchAPITaskRequest;
use App\Models\Project;
use App\Repositories\TaskRepositoryInterface;

class TaskApiController extends Controller
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function getTasksByUser(FetchAPITaskRequest $request, Project $project)
    {
        $tasks = $this->taskRepository->findByUserId($request->getUserId(), $project->id);

        return response()->json($tasks);
    }
}
