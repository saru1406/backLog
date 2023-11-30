<?php

namespace App\Repositories;

class ApiTaskParams
{
    /**
     * @var integer|null
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
     * @var boolean
     */
    private bool $isPagination;

    /**
     * @param integer|null $userId
     * @param string|null $status
     * @param string|null $priority
     * @param boolean $isPagination
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
     * @return boolean
     */
    public function getIsPagination(): bool
    {
        return $this->isPagination;
    }
}
