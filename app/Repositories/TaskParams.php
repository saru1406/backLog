<?php

namespace App\Repositories;

class TaskParams
{
    /**
     * @var integer
     */
    private int $userId;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $contents;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var string
     */
    private string $priority;

    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $endDate;

    public function __construct(
        int $userId,
        string $title,
        string $contents,
        string $status,
        string $priority,
        ?string $startDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
        $this->status = $status;
        $this->priority = $priority;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * ユーザID取得
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * タイトル取得
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * 内容取得
     *
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * 状態取得
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * 優先度取得
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * 開始日取得
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * 終了日取得
     *
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
}
