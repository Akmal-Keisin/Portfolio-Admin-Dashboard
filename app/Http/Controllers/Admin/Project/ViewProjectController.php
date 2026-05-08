<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\TechStack\TechStackCollection;
use App\Models\Project;
use App\Models\TechStack;
use Inertia\Inertia;

class ViewProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->with(['techStacks'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('admin/project/Index', [
            'projects' => new ProjectCollection($projects),
        ]);
    }

    public function create()
    {
        $techStacks = new TechStackCollection(TechStack::all());

        return Inertia::render('admin/project/Create', [
            'techStacks' => $techStacks,
        ]);
    }

    public function edit(Project $project)
    {
        $project->load('techStacks');
        $techStacks = new TechStackCollection(TechStack::all());

        return Inertia::render('admin/project/Edit', [
            'project' => $project,
            'techStacks' => $techStacks,
        ]);
    }
}
