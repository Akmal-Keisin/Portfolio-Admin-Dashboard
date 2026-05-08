<?php

namespace App\Http\Controllers\Admin\TechStack;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TechStack\StoreTechStackRequest;
use App\Models\TechStack;

class StoreTechStackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreTechStackRequest $request)
    {
        $data = [
            'name' => trim($request->name),
            'description' => trim($request->description),
        ];

        $techStack = new TechStack($data);
        $techStack->save();

        return to_route('tech-stack.index')->with([
            'success' => 'New tech stack created successfully',
        ]);
    }
}
