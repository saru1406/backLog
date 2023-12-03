<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Type;

class TypeRepository implements TypeRepositoryInterface
{
    public function store(Project $project, string $typeName): void
    {
        Type::create([
            'name' => $typeName,
            'project_id' => $project->id,
        ]);
    }
}
