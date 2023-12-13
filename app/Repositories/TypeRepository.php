<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository implements TypeRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function store(int $projectId, string $typeName): void
    {
        Type::create([
            'name' => $typeName,
            'project_id' => $projectId,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $typeId): void
    {
        Type::findOrFail($typeId)->delete();
    }
}
