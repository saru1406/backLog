<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentService implements CommentServiceInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function storeByTask(int $taskId, string $comment): void
    {
        $userId = Auth::id();
        $params = [
            'commentable_type' => 'App\Models\Task',
            'commentable_id' => $taskId,
            'user_id' => $userId,
            'body' => $comment,
        ];
        $this->commentRepository->store($params);
    }

    /**
     * {@inheritDoc}
     */
    public function storeByChildTask(int $childTaskId, string $comment): void
    {
        $userId = Auth::id();
        $params = [
            'commentable_type' => 'App\Models\ChildTask',
            'commentable_id' => $childTaskId,
            'user_id' => $userId,
            'body' => $comment,
        ];
        $this->commentRepository->store($params);
    }
}
