<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function storeProject(?int $companyId, string $name, string $key): Project
    {
        return Project::create([
            'company_id' => $companyId,
            'name' => $name,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectNames(?User $user): Collection
    {
        return $user->projects()->select('projects.id', 'projects.name')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function fetchProjectNameByCompanyId(int $companyId): Collection
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
    public function getUsers(Project $project): Collection
    {
        return $project->users;
    }

    /**
     * {@inheritDoc}
     */
    public function getTasks(Project $project): Collection
    {
        return $project->tasks;
    }
}
