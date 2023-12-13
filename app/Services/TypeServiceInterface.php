<?php

namespace App\Services;

interface TypeServiceInterface
{
    /**
     * Type名保存
     *
     * @param integer $projectId
     * @param string $typeName
     * @return void
     */
    public function store(int $projectId, string $typeName): void;

    /**
     * Type削除
     *
     * @param integer $typeId
     * @return void
     */
    public function destroy(int $typeId): void;
}
