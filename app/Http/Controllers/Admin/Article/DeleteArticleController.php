<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class DeleteArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Article $article)
    {
        $article->delete();

        return to_route('article.index')->with([
            'success' => 'Article deleted successfully'
        ]);
    }
}
