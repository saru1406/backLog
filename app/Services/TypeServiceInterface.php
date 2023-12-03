<?php

namespace App\Services;

use App\Models\Project;

interface TypeServiceInterface
{
    /**
     * Type名保存
     *
     * @param string $typeName
     * @return void
     */
    public function store(Project $project, string $typeName): void;
}
