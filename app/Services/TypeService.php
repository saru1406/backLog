<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\TypeRepositoryInterface;

class TypeService implements TypeServiceInterface
{
    public function __construct(private TypeRepositoryInterface $typeRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function store(Project $project, string $typeName): void
    {
        $this->typeRepository->store($project, $typeName);
    }
}
