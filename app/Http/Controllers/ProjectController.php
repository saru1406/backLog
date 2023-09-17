<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Services\ProjectServiceInterface;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function __construct(private ProjectServiceInterface $projectService)
    {
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
    public function store(StoreProjectRequest $request)
    {
        $name = $request->getName();
        $key = $request->getKey();

        $this->projectService->storeProject($name, $key);

        return to_route('projects.index');
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
        //
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
}
