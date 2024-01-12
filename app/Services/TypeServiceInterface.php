<?php

declare(strict_types=1);

namespace App\Services;

interface TypeServiceInterface
{
    /**
     * Type名保存
     *
     * @param int $projectId
     * @param string $typeName
     * @return void
     */
    public function store(int $projectId, string $typeName): void;

    /**
     * Type削除
     *
     * @param int $typeId
     * @return void
     */
    public function destroy(int $typeId): void;
}
