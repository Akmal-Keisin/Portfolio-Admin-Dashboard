<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class UpdateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = trim($request->name);
        $category->description = trim($request->description);
        $category->save();

        return to_route('category.index')->with([
            'success' => 'New category updated successfully'
        ]);
    }
}
