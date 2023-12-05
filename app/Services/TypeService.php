<?php

namespace App\Services;

use App\Repositories\TypeRepositoryInterface;

class TypeService implements TypeServiceInterface
{
    public function __construct(
        private TypeRepositoryInterface $typeRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function store(int $projectId, string $typeName): void
    {
        $this->typeRepository->store($projectId, $typeName);
    }
}
