<?php

declare(strict_types=1);

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
     * @param int $typeId
     * @return void
     */
    public function destroy(int $typeId): void;
}
