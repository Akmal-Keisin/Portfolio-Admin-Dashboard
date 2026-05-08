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
        if ($category->articles()->exists()) {
            return back()->with([
                'error' => 'Cannot delete category because it has associated articles.',
            ]);
        }

        $category->delete();

        return to_route('category.index')->with([
            'success' => 'Category deleted successfully',
        ]);
    }
}
