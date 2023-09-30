<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ProjectServiceInterface
{
    /**
     * プロジェクト保存
     *
     * @param string $name
     * @param string $key
     * @param User $name
     * @return void
     */
    public function storeProject(string $name, string $key, ?User $user): void;

    /**
     * プロジェクト名取得
     *
     * @return Collection
     */
    public function getProjectNames(): Collection;

    /**
     * プロジェクトに紐づくユーザーを取得
     *
     * @param Project $project
     * @return Collection
     */
    public function getProjectUsers(Project $project): Collection;

    /**
     * プロジェクトに追加されていないユーザー取得
     *
     * @param Collection $projectUsers
     * @return Collection
     */
    public function getProjectNotUsers(Collection $projectUsers): Collection;
}
