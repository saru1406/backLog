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
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $group;

    /**
     * @var string|null
     */
    private ?string $range;

    /**
     * @param integer|null $userId
     * @param string|null $status
     * @param string|null $priority
     * @param boolean $isPagination
     * @param string|null $startDate
     * @param string|null $group
     * @param string|null $range
     */
    public function __construct(
        ?int $userId,
        ?string $status,
        ?string $priority,
        bool $isPagination,
        ?string $startDate,
        ?string $group,
        ?string $range
    ) {
        $this->userId = $userId;
        $this->status = $status;
        $this->priority = $priority;
        $this->isPagination = $isPagination;
        $this->startDate = $startDate;
        $this->group = $group;
        $this->range = $range;
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

    /**
     * 表示開始日取得
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * グループを取得
     *
     * @return string|null
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * 表示範囲を取得
     *
     * @return string|null
     */
    public function getRange(): ?string
    {
        return $this->range;
    }
}
