<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    /**
     * プロジェクト取得
     *
     * @param integer $projectId
     * @param array $option
     * @return Project
     */
    public function findOrFail(int $projectId, array $option = []): Project;

    /**
     * プロジェクト保存
     *
     * @param integer|null $companyId
     * @param integer|null $userId
     * @param string $name
     * @return Project
     */
    public function store(?int $companyId, ?int $userId, string $name): Project;

    /**
     * プロジェクト取得
     *
     * @param User|null $userId
     * @return Collection
     */
    public function fetchProject(?User $user): Collection;

    /**
     * Companyに紐づくプロジェクト取得
     *
     * @param int $companyId
     * @return Collection
     */
    public function fetchProjectByCompanyId(int $companyId): Collection;

    /**
     * プロジェクトに紐づくユーザー取得
     *
     * @param Project $project
     * @return Collection
     */
    public function getProjectUsers(Project $project, $companyId): Collection;

    /**
     * プロジェクトにユーザーを追加
     *
     * @param integer $userId
     * @param Project $project
     * @return void
     */
    public function storeProjectUser(int $userId, Project $project): void;
}
