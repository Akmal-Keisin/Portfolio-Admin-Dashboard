<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Inertia\Inertia;

class ViewTagController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/tag/Index');
    }

    public function create() {}
    public function edit(Tag $tag) {}
}
