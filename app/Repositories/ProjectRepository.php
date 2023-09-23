<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
}
