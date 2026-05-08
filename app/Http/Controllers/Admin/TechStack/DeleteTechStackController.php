<?php

namespace App\Http\Controllers\Admin\TechStack;

use App\Http\Controllers\Controller;
use App\Models\TechStack;

class DeleteTechStackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(TechStack $techStack)
    {
        $techStack->delete();

        return to_route('tech-stack.index')->with([
            'success' => 'Tech stack deleted successfully',
        ]);
    }
}
