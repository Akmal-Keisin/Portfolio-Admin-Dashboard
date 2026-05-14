<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a paginated listing of categories.
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->withCount('articles')
            ->paginate(15);

        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified category by slug.
     */
    public function show(Category $category): CategoryResource
    {
        $category->loadCount('articles');

        return new CategoryResource($category);
    }
}
