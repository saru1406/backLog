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
     * @param User|null $name
     * @return void
     */
    public function storeProject(string $name, ?User $user): void;

    /**
     * プロジェクト名取得
     *
     * @return Collection
     */
    public function getProjectNames(): Collection;

    /**
     * プロジェクトにユーザーを追加
     *
     * @param integer $userId
     * @param Project $project
     * @return void
     */
    public function storeProjectUser(int $userId, Project $project): void;


    /**
     * プロジェクトに紐づくユーザーを取得
     *
     * @param Project $project
     * @return Collection|User|null
     */
    public function getProjectUsers(Project $project): Collection;

    /**
     * プロジェクトに追加されていないユーザー取得
     *
     * @param Collection $projectUsers
     * @return Collection
     */
    public function getProjectNotUsers(Collection $projectUsers): Collection;

    /**
     * プロジェクトに紐づくユーザを取得
     *
     * @param Project $project
     * @return Collection
     */
    public function getUsers(Project $project): Collection;

    /**
     * プロジェクトに紐づく種別を取得
     *
     * @param Project $project
     * @return Collection
     */
    public function fetchProjectTypes(Project $project): Collection;
}
