<?php

namespace App\Repositories;

use App\Models\ProjectTaskNumber;

class ProjectTaskNumberRepository implements ProjectTaskNumberRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetchTaskNumberbyProjectId(int $projectId): ?ProjectTaskNumber
    {
        return ProjectTaskNumber::where('project_id', $projectId)->latest()->first();
    }

    /**
     * {@inheritDoc}
     */
    public function store(array $params): void
    {
        ProjectTaskNumber::create($params);
    }
}
