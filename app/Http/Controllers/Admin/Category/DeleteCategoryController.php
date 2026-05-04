<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class DeleteCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category)
    {
        dd($category);
        $category->delete();

        return to_route('category.index')->with([
            'success' => 'Category deleted successfully'
        ]);
    }
}
