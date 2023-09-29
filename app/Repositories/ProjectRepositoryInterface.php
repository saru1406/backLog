<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    /**
     * プロジェクト保存
     *
     * @param string $name
     * @param string $key
     * @return Project
     */
    public function storeProjet(string $name, string $key): Project;

    /**
     * プロジェクトの名取得
     *
     * @return Collection
     */
    public function getProjectNames(): Collection;

    public function getProjectUsers(Project $project): Collection;
}
