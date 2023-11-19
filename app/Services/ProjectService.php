<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProjectService implements ProjectServiceInterface
{
    public function __construct(private ProjectRepositoryInterface $projectRepository, private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectNames(): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if ( $companyId ) {
            return $this->projectRepository->fetchProjectNameByCompanyId($companyId);
        }

        return $this->projectRepository->getProjectNames($user);
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, string $key, ?User $user): void
    {
        $project = $this->projectRepository->storeProject($user->company_id, $name, $key);
        $this->projectRepository->storeProjectUser($user->id, $project);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectUsers(Project $project): Collection
    {
        return $this->projectRepository->getProjectUsers($project);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectNotUsers(Collection $projectUsers): Collection
    {
        $projectUserIds = $projectUsers->pluck('id');
        return $this->userRepository->getProjectNotUser($projectUserIds);
    }
}
