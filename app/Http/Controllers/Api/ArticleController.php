<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Display a paginated listing of published articles.
     */
    public function index(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->paginate(15);

        return ArticleResource::collection($articles);
    }

    /**
     * Display the specified article by slug.
     */
    public function show(Article $article): ArticleResource
    {
        $article->load(['author', 'category', 'tags']);

        return new ArticleResource($article);
    }
}
