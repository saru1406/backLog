<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository implements TypeRepositoryInterface
{
    public function store(int $projectId, string $typeName): void
    {
        Type::create([
            'name' => $typeName,
            'project_id' => $projectId,
        ]);
    }
}
