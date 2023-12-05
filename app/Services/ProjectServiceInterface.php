<?php

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
     * @param integer $projectId
     * @return Project
     */
    public function fetchViewDataShow(int $projectId): Project;

    /**
     * editに表示するデータ取得
     *
     * @param integer $projectId
     * @return Project
     */
    public function fetchViewDataEdit(int $projectId): Collection;

    /**
     * プロジェクトにユーザーを追加
     *
     * @param integer $userId
     * @param integer $project
     * @return void
     */
    public function storeProjectUser(int $userId, int $project): void;

    /**
     * ボードに表示するデータ取得
     *
     * @param integer $projectId
     * @return Collection
     */
    public function fetchViewDataBoardGantt(int $projectId): Collection;


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
}
