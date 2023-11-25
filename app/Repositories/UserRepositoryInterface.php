<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * プロジェクトに紐づいていないユーザー取得
     *
     * @param int $companyId
     * @param Collection $projectUserIds
     * @return Collection
     */
    public function getProjectNotUser(int $companyId, Collection $projectUserIds): Collection;

    /**
     * 企業IDと紐づけ
     *
     * @param int $userId
     * @param int $companyId
     * @return void
     */
    public function patchUserByCompanyId(int $userId, int $companyId): void;
}
