<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Carbon;

class ChildTaskParams
{
    /**
     * @var int
     */
    private int $userId;

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
    private ?string $branchName;

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
     * @param string $title
     * @param string|null $contents
     * @param string $status
     * @param string|null $priority
     * @param string|null $branchName
     * @param string|null $startDate
     * @param string|null $endDate
     */
    public function __construct(
        int $userId,
        string $title,
        ?string $contents,
        string $status,
        ?string $priority,
        ?string $branchName,
        ?string $startDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
        $this->status = $status;
        $this->priority = $priority;
        $this->branchName = $branchName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'title' => $this->title,
            'content' => $this->contents,
            'status' => $this->status,
            'priority' => $this->priority,
            'branch_name' => $this->branchName,
            'start_date' => Carbon::parse($this->startDate)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->endDate)->format('Y-m-d'),
        ];
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
     * ブランチ名取得
     *
     * @return string|null
     */
    public function getBranchName(): ?string
    {
        return $this->branchName;
    }

    /**
     * 開始日取得
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return Carbon::parse($this->startDate)->format('Y-m-d');
    }

    /**
     * 終了日取得
     *
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return Carbon::parse($this->endDate)->format('Y-m-d');
    }
}
