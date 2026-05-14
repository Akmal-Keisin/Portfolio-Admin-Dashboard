<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    /**
     * Display a paginated listing of tags.
     */
    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::query()
            ->withCount('articles')
            ->paginate(15);

        return TagResource::collection($tags);
    }

    /**
     * Display the specified tag by slug.
     */
    public function show(Tag $tag): TagResource
    {
        $tag->loadCount('articles');

        return new TagResource($tag);
    }
}
