<?php

namespace App\Repositories;

interface ProjectRepositoryInterface
{
    /**
     * プロジェクト保存
     *
     * @param string $name
     * @param string $key
     * @return void
     */
    public function StoreProjet(string $name, string $key): void;
}
