<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchApiGantRequest;
use App\Http\Requests\FetchApiTaskRequest;
use App\Http\Requests\UpdateApiTaskStatuRequest;
use App\Repositories\TaskRepositoryInterface;
use App\UseCase\TaskUseCase;
use Illuminate\Support\Facades\Log;

class TaskApiController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskUseCase $taskUseCase,
    ) {
    }

    public function fetchTasks(FetchApiTaskRequest $request, int $projectId)
    {
        $tasks = $this->taskRepository->searchTasksByParameters($projectId, $request->getParams());
        Log::info('タスク数'.$tasks->count());

        return response()->json($tasks);
    }

    public function fetchGant(FetchApiGantRequest $request, int $projectId)
    {
        $tasks = $this->taskRepository->gantTasksByParameters($projectId, $request->getParams());

        return response()->json($tasks);
    }

    public function updateTaskStatus(UpdateApiTaskStatuRequest $request, int $projectId, int $taskId)
    {
        Log::info('来たよ');
        $this->taskUseCase->updateTaskStatus($taskId, $request->getStatus());
    }
}
