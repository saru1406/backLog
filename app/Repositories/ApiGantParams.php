<?php

namespace App\Repositories;

class ApiGantParams
{
    /**
     * @var string|null
     */
    private ?string $status;

    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $group;

    /**
     * @var int|null
     */
    private ?int $range;

    /**
     * @param string|null $status
     * @param string|null $startDate
     * @param string|null $group
     * @param integer|null $range
     */
    public function __construct(
        ?string $status,
        ?string $startDate,
        ?string $group,
        ?int $range
    ) {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->group = $group;
        $this->range = $range;
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
     * @return int|null
     */
    public function getRange(): ?int
    {
        return $this->range;
    }
}
