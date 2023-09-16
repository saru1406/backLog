<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function StoreProjet(string $name, string $key): void
    {
        Project::create([
            'name' => $name,
            'key' => $key,
        ]);
    }
}
