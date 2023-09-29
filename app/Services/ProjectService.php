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
        $user->projects()->attach($project->id);
    }

    public function getProjectUsers(Project $project): Collection
    {
        return $this->projectRepository->getProjectUsers($project);
    }

    public function getProjectNotUsers(Collection $projectUsers): Collection
    {
        $projectUserIds = $projectUsers->pluck('id');
        return $this->userRepository->getUser($projectUserIds);
    }
}
