<?php

namespace App\Http\Controllers\Admin\TechStack;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechStack\TechStackResource;
use App\Models\TechStack;
use Inertia\Inertia;

class ViewTechStackController extends Controller
{
    public function index()
    {
        $techStacks = TechStack::query()
            ->orderBy('name', 'asc')
            ->paginate(20);

        return Inertia::render('admin/tech-stack/Index', [
            'techStacks' => TechStackResource::collection($techStacks),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/tech-stack/Create');
    }

    public function edit(TechStack $techStack)
    {
        return Inertia::render('admin/tech-stack/Edit', [
            'techStack' => new TechStackResource($techStack),
        ]);
    }
}
