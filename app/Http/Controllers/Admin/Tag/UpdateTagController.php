<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class UpdateTagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateTagRequest $request, Tag $tag)
    {
        $tag->name = trim($request->name);
        $tag->description = trim($request->description);
        $tag->save();

        return to_route('tag.index')->with([
            'success' => 'New tag updated successfully',
        ]);
    }
}
