<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCase\ProjectUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProjectApiController extends Controller
{
    public function __construct(private ProjectUseCase $projectUsecase)
    {
    }

    public function newTasks(int $projectId): JsonResponse
    {
        $tasks = $this->projectUsecase->fetchNewTasks($projectId);
        Log::info($tasks);

        return response()->json($tasks);
    }
}
