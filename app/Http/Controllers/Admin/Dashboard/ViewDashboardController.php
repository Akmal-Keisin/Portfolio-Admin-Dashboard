<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ViewDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/dashboard/Index');
    }
}
