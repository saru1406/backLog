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
     * @param int|null $companyId
     * @param string $name
     * @param string $key
     * @return Project
     */
    public function storeProject(?int $companyId, string $name, string $key): Project;

    /**
     * プロジェクト名取得
     *
     * @param User|null $userId
     * @return Collection
     */
    public function getProjectNames(?User $user): Collection;

    /**
     * Companyに紐づくプロジェクト名取得
     *
     * @param int $companyId
     * @return Collection
     */
    public function fetchProjectNameByCompanyId(int $companyId): Collection;

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
