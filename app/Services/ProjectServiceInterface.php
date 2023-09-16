<?php

namespace App\Services;

interface ProjectServiceInterface
{
    /**
     * プロジェクト保存
     *
     * @param string $name
     * @param string $key
     * @return void
     */
    public function StoreProject(string $name, string $key): void;
}
