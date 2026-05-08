<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Models\Category;

class StoreCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCategoryRequest $request)
    {
        $data = [
            'name' => trim($request->name),
            'description' => trim($request->description),
        ];

        $category = new Category($data);
        $category->save();

        return to_route('category.index')->with([
            'success' => 'New category created successfully',
        ]);
    }
}
