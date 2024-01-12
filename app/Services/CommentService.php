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
            'comment' => $comment,
        ];
        $this->commentRepository->store($params);
    }
}
