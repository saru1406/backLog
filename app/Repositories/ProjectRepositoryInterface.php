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
    public function storeProject(string $name, string $key): Project;

    /**
     * プロジェクトの名取得
     *
     * @return Collection
     */
    public function getProjectNames(): Collection;

    /**
     * プロジェクトに紐づくユーザー取得
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
    public function storeProjectUser(int $userId, Project $project): void;

    /**
     * プロジェクトに紐づくユーザー取得
     *
     * @param Project $project
     * @return Collection
     */
    public function getUsers(Project $project): Collection;

    /**
     * プロジェクトに紐づく課題取得
     *
     * @param Project $project
     * @return Collection
     */
    public function getTasks(Project $project): Collection;
}
