<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getProjectNotUser(Collection $projectUserIds): Collection
    {
        return User::whereNotIn('id', $projectUserIds)->get();
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
