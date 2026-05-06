<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
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
        return Inertia::render('admin/article/Index');
    }

    public function create()
    {
        $categories = new CategoryCollection(Category::all());
        $tags = new TagCollection(Tag::all());

        return Inertia::render('admin/article/Create', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function edit(Article $article)
    {
        return Inertia::render('admin/article/Edit', [
            'article' => $article
        ]);
    }
}
