<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Inertia\Inertia;

class ViewTagController extends Controller
{
    public function index()
    {
        $tags = Tag::query()
            ->orderBy('name', 'asc')
            ->paginate(20);

        return Inertia::render('admin/tag/Index', [
            'tags' => TagResource::collection($tags),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/tag/Create');
    }

    public function edit(Tag $tag)
    {
        return Inertia::render('admin/tag/Edit', [
            'tag' => new TagResource($tag),
        ]);
    }
}
