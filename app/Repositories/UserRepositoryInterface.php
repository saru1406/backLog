<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
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
    public function fetchProjectNotUser(int $companyId, Collection $projectUserIds): Collection;

    /**
     * 企業IDと紐づけ
     *
     * @param int $userId
     * @param int $companyId
     * @return void
     */
    public function patchUserByCompanyId(int $userId, int $companyId): void;

    /**
     * ユーザ作成
     *
     * @param array $params
     * @return User
     */
    public function store(array $params = []): User;

    /**
     * メールアドレスからユーザー取得
     *
     * @param string $email
     * @return User|null
     */
    public function firstByEmail(string $email): ?User;
}
