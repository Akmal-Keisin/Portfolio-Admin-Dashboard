<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * Display a paginated listing of completed projects.
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = Project::query()
            ->with(['techStacks'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);

        return ProjectResource::collection($projects);
    }

    /**
     * Display the specified project by slug.
     */
    public function show(Project $project): ProjectResource
    {
        $project->load(['techStacks']);

        return new ProjectResource($project);
    }
}
