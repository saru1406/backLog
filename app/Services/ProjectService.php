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

    public function getProjectNames(): Collection
    {
        return $this->projectRepository->getProjectNames();
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, string $key, ?User $user): void
    {
        $project = $this->projectRepository->storeProjet($name, $key);
        $this->projectRepository->storeProjetUser($user->id, $project);
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
        dd($projectUserIds);
        return $this->userRepository->getProjectNotUser($projectUserIds);
    }
}
