<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\StoreTagRequest;
use App\Models\Tag;

class StoreTagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreTagRequest $request)
    {
        $data = [
            'name' => trim($request->name),
            'description' => trim($request->description),
        ];

        $tag = new Tag($data);
        $tag->save();

        return to_route('tag.index')->with([
            'success' => 'New tag created successfully',
        ]);
    }
}
