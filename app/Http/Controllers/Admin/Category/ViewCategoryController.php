<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Inertia\Inertia;

class ViewCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('name', 'asc')
            ->paginate(20);

        return Inertia::render('admin/category/Index', [
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/category/Create');
    }

    public function edit(Category $category)
    {
        return Inertia::render('admin/category/Edit', [
            'category' => $category->toResource()
        ]);
    }
}
