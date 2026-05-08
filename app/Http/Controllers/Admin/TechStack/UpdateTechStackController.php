<?php

namespace App\Http\Controllers\Admin\TechStack;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TechStack\UpdateTechStackRequest;
use App\Models\TechStack;

class UpdateTechStackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateTechStackRequest $request, TechStack $techStack)
    {
        $techStack->name = trim($request->name);
        $techStack->description = trim($request->description);
        $techStack->save();

        return to_route('tech-stack.index')->with([
            'success' => 'Tech stack updated successfully',
        ]);
    }
}
