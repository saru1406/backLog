<?php

namespace App\Services;

use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectService implements ProjectServiceInterface
{
   public function __construct(private ProjectRepositoryInterface $projectRepository)
    {
    }

    public function getProjectNames(): Collection
    {
        return $this->projectRepository->getProjectNames();
    }

    /**
     * {@inheritDoc}
     */
    public function StoreProject(string $name, string $key): void
    {
        $this->projectRepository->storeProjet($name, $key);
    }
}
