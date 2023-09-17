<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface ProjectServiceInterface
{
    /**
     * プロジェクト保存
     *
     * @param string $name
     * @param string $key
     * @return void
     */
    public function storeProject(string $name, string $key): void;

    /**
     * プロジェクト名取得
     *
     * @return Collection
     */
    public function getProjectNames(): Collection;
}
