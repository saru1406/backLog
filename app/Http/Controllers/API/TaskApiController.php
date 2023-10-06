<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchAPITaskRequest;
use App\Repositories\TaskRepositoryInterface;

class TaskApiController extends Controller
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function getTasksByUser(FetchAPITaskRequest $request)
    {
        $tasks = $this->taskRepository->findByUserId($request->getUserId());
        return response()->json($tasks);
    }
}
