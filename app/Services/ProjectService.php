<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProjectService implements ProjectServiceInterface
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private UserRepositoryInterface $userRepository,
        private CompanyRepositoryInterface $companyRepository,
        private TypeRepositoryInterface $typeRepository
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getProjectNames(): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if ($companyId) {
            return $this->projectRepository->fetchProjectNameByCompanyId($companyId);
        }

        return $this->projectRepository->getProjectNames($user);
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, ?User $user): void
    {
        $project = $this->projectRepository->storeProject($user->company_id, $name);
        $this->projectRepository->storeProjectUser($user->id, $project);
        $typeNames = ['実装', 'バグ', '改善'];

        foreach ($typeNames as $typeName) {
            $this->typeRepository->store($project, $typeName);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function storeProjectUser(int $userId, Project $project): void
    {
        $this->projectRepository->storeProjectUser($userId, $project);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectUsers(Project $project): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if (!$companyId) {
            return collect([$user]);
        }

        return $this->projectRepository->getProjectUsers($project, $companyId);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectNotUsers(Collection $projectUsers): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if (!$companyId) {
            return collect([$user]);
        }
        $projectUserIds = $projectUsers->pluck('id');

        return $this->userRepository->getProjectNotUser($companyId, $projectUserIds);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers(Project $project): Collection
    {
        return $this->projectRepository->getUsers($project);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchProjectTypes(Project $project): Collection
    {
        return $this->projectRepository->fetchProjectTypes($project);
    }
}
