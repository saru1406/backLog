<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * プロジェクトに紐づいていないユーザー取得
     *
     * @param Collection $projectUserIds
     * @return Collection
     */
    public function getProjectNotUser(Collection $projectUserIds): Collection;
}
