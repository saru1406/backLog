<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreProjectUserRequest;
use App\Models\Project;
use App\Services\ProjectServiceInterface;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectServiceInterface $projectService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = $this->projectService->fetchViewDataIndex();

        return Inertia::render('Project/Index', [
            'projects' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->projectService->store($request->getName());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $projectId)
    {
        $project = $this->projectService->fetchViewDataShow($projectId);

        return Inertia::render('Project/Show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $projectId)
    {
        $data = $this->projectService->fetchViewDataEdit($projectId);

        return Inertia::render('Project/Edit', [
            'project' => $data['project'],
            'projectNotUsers' => $data['project_not_users'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $projectId)
    {
        $this->projectService->destroy($projectId);

        return to_route('projects.index');
    }

    public function destroyUser(int $projectId, int $userId)
    {
        $this->projectService->destroyUser($projectId, $userId);
    }

    public function storeProjectUser(StoreProjectUserRequest $request, int $projectId)
    {
        $this->projectService->storeProjectUser($request->getUserId(), $projectId);
    }

    public function board(int $projectId)
    {
        $project = $this->projectService->fetchViewDataBoardGantt($projectId);

        return Inertia::render('Project/Board', [
            'project' => $project,
        ]);
    }

    public function gant(int $projectId)
    {
        $project = $this->projectService->fetchViewDataBoardGantt($projectId);

        return Inertia::render('Project/Gant', [
            'project' => $project,
        ]);
    }
}
