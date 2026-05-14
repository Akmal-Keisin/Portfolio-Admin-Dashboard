<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechStack\TechStackResource;
use App\Models\TechStack;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TechStackController extends Controller
{
    /**
     * Display a paginated listing of tech stacks.
     */
    public function index(): AnonymousResourceCollection
    {
        $techStacks = TechStack::query()
            ->withCount('projects')
            ->paginate(15);

        return TechStackResource::collection($techStacks);
    }

    /**
     * Display the specified tech stack by slug.
     */
    public function show(TechStack $techStack): TechStackResource
    {
        $techStack->loadCount('projects');

        return new TechStackResource($techStack);
    }
}
