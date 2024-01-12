<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findOrFail(int $projectId, array $option = []): Project
    {
        return Project::with($option)->findOrFail($projectId);
    }

    /**
     * {@inheritdoc}
     */
    public function store(?int $companyId, ?int $userId, string $name): Project
    {
        $project = Project::create([
            'company_id' => $companyId,
            'name' => $name,
        ]);

        if ($userId) {
            $this->storeProjectUser($userId, $project);
        }

        return $project;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchProject(?User $user): Collection
    {
        return $user->projects()->select('projects.id', 'projects.name')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function fetchProjectByCompanyId(int $companyId): Collection
    {
        return Project::where('company_id', $companyId)->select('id', 'name')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectUsers(Project $project, $companyId): Collection
    {
        return Company::find($companyId)->projects->find($project->id)->users;
    }

    /**
     * {@inheritDoc}
     */
    public function storeProjectUser(int $userId, Project $project): void
    {
        $project->users()->attach($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $projectId): void
    {
        Project::findOrFail($projectId)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function destroyUser(Project $project, int $userId): void
    {
        $project->users()->detach($userId);
    }
}
