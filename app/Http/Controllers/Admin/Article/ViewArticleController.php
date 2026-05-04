<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/article/Index');
    }

    public function create()
    {
        return Inertia::render('admin/article/Create');
    }
    public function edit(Article $article) {}
}
