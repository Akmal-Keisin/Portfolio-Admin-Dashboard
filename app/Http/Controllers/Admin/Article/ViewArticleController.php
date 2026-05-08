<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Inertia\Inertia;

class ViewArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->with(['author', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('admin/article/Index', [
            'articles' => new ArticleCollection($articles),
        ]);
    }

    public function create()
    {
        $categories = new CategoryCollection(Category::all());
        $tags = new TagCollection(Tag::all());

        return Inertia::render('admin/article/Create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function edit(Article $article)
    {
        // Eager load the tags relationship to be passed to the view
        $article->load('tags');

        $categories = new CategoryCollection(Category::all());
        $tags = new TagCollection(Tag::all());

        return Inertia::render('admin/article/Edit', [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
}
