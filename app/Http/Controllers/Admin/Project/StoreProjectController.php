<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreProjectController extends Controller
{
    public function __invoke(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('projects', 'public');
            }

            $project = Project::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'excerpt' => $validated['excerpt'],
                'thumbnail' => $thumbnailPath,
                'live_url' => $validated['live_url'],
                'repo_url' => $validated['repo_url'],
                'status' => $validated['status'],
                'featured' => $validated['featured'],
            ]);

            if (! empty($validated['tech_stacks'])) {
                $project->techStacks()->sync($validated['tech_stacks']);
            }
        });

        return redirect()->route('project.index')
            ->with('success', 'Project created successfully.');
    }
}
