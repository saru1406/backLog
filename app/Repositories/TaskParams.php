<?php

namespace App\Repositories;

class TaskParams
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var int|null
     */
    private ?int $typeId;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string|null
     */
    private ?string $contents;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var string|null
     */
    private ?string $priority;

    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $endDate;

    /**
     * @param int $userId
     * @param int|null $typeId
     * @param string $title
     * @param string|null $contents
     * @param string $status
     * @param string|null $priority
     * @param string|null $startDate
     * @param string|null $endDate
     */
    public function __construct(
        int $userId,
        ?int $typeId,
        string $title,
        ?string $contents,
        string $status,
        ?string $priority,
        ?string $startDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->typeId = $typeId;
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
     * 種別ID取得
     *
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        return $this->typeId;
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
     * @return string|null
     */
    public function getContents(): ?string
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
     * @return string|null
     */
    public function getPriority(): ?string
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
