<?php

namespace App\Repositories;

use App\Models\Project;

interface TypeRepositoryInterface
{
    /**
     * Type名保存
     *
     * @param Project $project
     * @param string $typeName
     * @return void
     */
    public function store(Project $project, string $typeName): void;
}
