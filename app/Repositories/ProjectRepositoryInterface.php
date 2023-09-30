<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
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

    /**
     * プロジェクトに紐づくユーザー
     *
     * @param Project $project
     * @return Collection
     */
    public function getProjectUsers(Project $project): Collection;

    /**
     * プロジェクトにユーザーを追加
     *
     * @param integer $userId
     * @param Project $project
     * @return void
     */
    public function storeProjetUser(int $userId, Project $project): void;
}
