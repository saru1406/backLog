<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function storeProjet(string $name, string $key): Project
    {
        return Project::create([
            'name' => $name,
            'key' => $key,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectNames(): Collection
    {
        return Project::select('id', 'name')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectUsers(Project $project): Collection
    {
        return $project->users;
    }

    /**
     * {@inheritDoc}
     */
    public function storeProjectUser(int $userId, Project $project): void
    {
        $project->users()->attach($userId);
    }

    public function getUsers(Project $project): Collection
    {
        return $project->users;
    }
}
