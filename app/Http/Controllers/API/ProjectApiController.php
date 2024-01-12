<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCase\ProjectUseCase;
use Illuminate\Http\JsonResponse;

class ProjectApiController extends Controller
{
    public function __construct(private ProjectUseCase $projectUsecase)
    {
    }

    public function newTasks(int $projectId): JsonResponse
    {
        $tasks = $this->projectUsecase->fetchNewTasks($projectId);

        return response()->json($tasks);
    }
}
