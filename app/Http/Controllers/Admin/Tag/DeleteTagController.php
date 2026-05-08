<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class DeleteTagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tag $tag)
    {
        $tag->delete();

        return to_route('tag.index')->with([
            'success' => 'Tag deleted successfully',
        ]);
    }
}
