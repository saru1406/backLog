<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProjectService implements ProjectServiceInterface
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private UserRepositoryInterface $userRepository,
        private TypeRepositoryInterface $typeRepository,
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataIndex(): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if ($companyId) {
            return $user->projects;
        }

        return $this->projectRepository->fetchProject($user);
    }

    /**
     * {@inheritDoc}
     */
    public function store(string $name): void
    {
        $user = Auth::user();

        $project = $this->projectRepository->store($user->company_id, $user->id, $name);

        $typeNames = ['実装', 'バグ', '改善'];
        foreach ($typeNames as $typeName) {
            $this->typeRepository->store($project->id, $typeName);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataShow(int $projectId): Project
    {
        return $this->projectRepository->findOrFail($projectId, ['tasks']);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataEdit(int $projectId): Collection
    {
        $project = $this->projectRepository->findOrFail($projectId, ['users', 'types']);
        $projectNotUsers = $this->fetchProjectNotAssignUsers($project->users);

        return collect(['project' => $project, 'project_not_users' => $projectNotUsers]);
    }

    /**
     * {@inheritDoc}
     */
    public function storeProjectUser(int $userId, int $projectId): void
    {
        $project = $this->projectRepository->findOrFail($projectId);
        $this->projectRepository->storeProjectUser($userId, $project);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchViewDataBoardGantt(int $projectId): Project
    {
        return $this->projectRepository->findOrFail($projectId, ['users']);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectUsers(Project $project): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if (! $companyId) {
            return collect([$user]);
        }

        return $this->projectRepository->getProjectUsers($project, $companyId);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchProjectNotAssignUsers(Collection $projectUsers): Collection
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        if (! $companyId) {
            return collect([]);
        }
        $projectUserIds = $projectUsers->pluck('id');

        return $this->userRepository->fetchProjectNotUser($companyId, $projectUserIds);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $projectId): void
    {
        $this->projectRepository->destroy($projectId);
    }

    /**
     * {@inheritDoc}
     */
    public function destroyUser(int $projectId, int $userId): void
    {
        $currentUser = Auth::user();
        if (! $currentUser->company_id) {
            return;
        }
        $project = $this->projectRepository->findOrFail($projectId);
        $this->projectRepository->destroyUser($project, $userId);
    }
}
