<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ProjectServiceInterface
{
    /**
     * プロジェクト名取得
     *
     * @return Collection
     */
    public function fetchViewDataIndex(): Collection;

    /**
     * プロジェクト保存
     *
     * @param string $name
     * @return void
     */
    public function store(string $name): void;

    /**
     * showに表示するデータ取得
     *
     * @param int $projectId
     * @return Project
     */
    public function fetchViewDataShow(int $projectId): Project;

    /**
     * editに表示するデータ取得
     *
     * @param int $projectId
     * @return Project
     */
    public function fetchViewDataEdit(int $projectId): Collection;

    /**
     * プロジェクトにユーザーを追加
     *
     * @param int $userId
     * @param int $project
     * @return void
     */
    public function storeProjectUser(int $userId, int $project): void;

    /**
     * ボードに表示するデータ取得
     *
     * @param int $projectId
     * @return Project
     */
    public function fetchViewDataBoardGantt(int $projectId): Project;

    /**
     * プロジェクトに紐づくユーザーを取得
     *
     * @param Project $project
     * @return Collection|User|null
     */
    public function getProjectUsers(Project $projectId): Collection;

    /**
     * プロジェクトに追加されていないユーザー取得
     *
     * @param Collection $projectUsers
     * @return Collection
     */
    public function fetchProjectNotAssignUsers(Collection $projectUsers): Collection;

    /**
     * プロジェクトの削除
     *
     * @param int $projectId
     * @return void
     */
    public function destroy(int $projectId): void;

    /**
     * プロジェクトに紐づくユーザー削除
     *
     * @param int $projectId
     * @param int $userId
     * @return void
     */
    public function destroyUser(int $projectId, int $userId): void;
}
