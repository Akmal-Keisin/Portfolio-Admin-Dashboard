<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class DeleteProjectController extends Controller
{
    public function __invoke(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('project.index')
            ->with('success', 'Project deleted successfully.');
    }
}
