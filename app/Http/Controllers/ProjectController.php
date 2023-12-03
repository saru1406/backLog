<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreProjectUserRequest;
use App\Services\ProjectServiceInterface;
use App\Services\TypeServiceInterface;
use App\Services\UserServiceInterface;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectServiceInterface $projectService,
        private UserServiceInterface $userService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectNames = $this->projectService->getProjectNames();

        return Inertia::render('Project/Index', [
            'projects' => $projectNames
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreProjectRequest $request)
    {
        // return Inertia::render('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, StoreProjectRequest $request)
    {
        $user = Auth::user();

        $this->projectService->storeProject($request->getName(), $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('Project/Show', [
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $projectUsers = $this->projectService->getProjectUsers($project);
        $projectNotUsers = $this->projectService->getProjectNotUsers($projectUsers);
        $projectTypes = $this->projectService->fetchProjectTypes($project);
        return Inertia::render('Project/Edit', [
            'project' => $project,
            'project_users' => $projectUsers,
            'project_not_users'  => $projectNotUsers,
            'project_types'=> $projectTypes
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
    public function destroy(Project $project)
    {
        //
    }

    public function storeProjectUser(StoreProjectUserRequest $request, Project $project)
    {
        $this->projectService->storeProjectUser($request->getUserId(), $project);
    }

    public function board(Project $project)
    {
        $projectUsers = $this->projectService->getProjectUsers($project);

        return Inertia::render('Project/Board', [
            'project' => $project,
            'project_users' => $projectUsers
        ]);
    }

    public function gant(Project $project)
    {
        $projectUsers = $this->projectService->getProjectUsers($project);

        return Inertia::render('Project/Gant', [
            'project' => $project,
            'project_users' => $projectUsers
        ]);
    }
}
