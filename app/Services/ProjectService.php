<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
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
        return $this->projectRepository->getProjectNames();
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, string $key, ?User $user): void
    {
        $project = $this->projectRepository->storeProject($name, $key);
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
