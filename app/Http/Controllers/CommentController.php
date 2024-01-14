<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\CommentServiceInterface;

class CommentController extends Controller
{
    public function __construct(private CommentServiceInterface $commentService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeByTask(StoreCommentRequest $request, int $projectId, int $taskId)
    {
        $this->commentService->storeByTask($taskId, $request->getComment());

        return to_route('projects.tasks.show', [
            'project' => $projectId,
            'task' => $taskId
        ]);
    }

    public function storeByChildTask(StoreCommentRequest $request, int $projectId, int $taskId, int $childTaskId)
    {
        $this->commentService->storeByChildTask($childTaskId, $request->getComment());

        return to_route('projects.tasks.child-tasks.show', [
            'project' => $projectId,
            'task' => $taskId,
            'child_task' => $childTaskId
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
