<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchApiTaskRequest;
use App\Http\Requests\UpdateApiChildTaskStatuRequest;
use App\UseCase\ChildTaskUseCase;

class ChildTaskApiController extends Controller
{
    public function __construct(
        private ChildTaskUseCase $childTaskUseCase
    ) {
    }

    public function fetchChildTasks(FetchApiTaskRequest $request, int $projectId)
    {
        $childTasks = $this->childTaskUseCase->fetchChildTasks($projectId, $request->getParams());

        return response()->json($childTasks);
    }

    public function updateChildTaskStatus(UpdateApiChildTaskStatuRequest $request, int $projectId, int $childTaskId)
    {
        $this->childTaskUseCase->updateChildTaskStatus($childTaskId, $request->getStatus());
    }
}
