<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateProjectController extends Controller
{
    public function __invoke(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $project) {
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($project->thumbnail) {
                    Storage::disk('public')->delete($project->thumbnail);
                }
                $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
            } else {
                unset($validated['thumbnail']);
            }

            $project->update($validated);

            if (isset($validated['tech_stacks'])) {
                $project->techStacks()->sync($validated['tech_stacks']);
            }
        });

        return redirect()->route('project.index')
            ->with('success', 'Project updated successfully.');
    }
}
