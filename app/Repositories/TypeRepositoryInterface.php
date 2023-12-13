<?php

namespace App\Repositories;

interface TypeRepositoryInterface
{
    /**
     * Type名保存
     *
     * @param int $project
     * @param string $typeName
     * @return void
     */
    public function store(int $project, string $typeName): void;

    /**
     * Type削除
     *
     * @param integer $typeId
     * @return void
     */
    public function destroy(int $typeId): void;
}
