<?php

namespace App\Services;

use App\Repositories\ProjectRepositoryInterface;

class ProjectService implements ProjectServiceInterface
{
   public function __construct(private ProjectRepositoryInterface $projectRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, string $key): void
    {
        $this->projectRepository->StoreProjet($name, $key);
    }
}
