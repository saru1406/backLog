<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function fetchProjectNotUser(int $companyId, Collection $projectUserIds): Collection
    {
        return User::where('company_id', $companyId)->whereNotIn('id', $projectUserIds)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function patchUserByCompanyId(int $userId, int $companyId): void
    {
        User::where('id', $userId)->update([
            'company_id' => $companyId
        ]);
    }
}
