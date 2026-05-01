<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/category/Index');
    }

    public function create() {}
    public function edit(Category $category) {}
}
