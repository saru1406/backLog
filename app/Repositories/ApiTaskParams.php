<?php

declare(strict_types=1);

namespace App\Repositories;

class ApiTaskParams
{
    /**
     * @var int|null
     */
    private ?int $userId;

    /**
     * @var string|null
     */
    private ?string $status;

    /**
     * @var string|null
     */
    private ?string $priority;

    /**
     * @var bool
     */
    private bool $isPagination;

    /**
     * @param int|null $userId
     * @param string|null $status
     * @param string|null $priority
     * @param bool $isPagination
     */
    public function __construct(
        ?int $userId,
        ?string $status,
        ?string $priority,
        bool $isPagination,
    ) {
        $this->userId = $userId;
        $this->status = $status;
        $this->priority = $priority;
        $this->isPagination = $isPagination;
    }

    /**
     * ユーザID取得
     *
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * 状態取得
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * 優先度取得
     *
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * ページネーションで取得の有無
     *
     * @return bool
     */
    public function getIsPagination(): bool
    {
        return $this->isPagination;
    }
}
