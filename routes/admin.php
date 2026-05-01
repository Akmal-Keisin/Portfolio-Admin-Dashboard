<?php

use App\Http\Controllers\Admin\Article\ViewArticleController;
use App\Http\Controllers\Admin\Category\ViewCategoryController;
use App\Http\Controllers\Admin\Dashboard\ViewDashboardController;
use App\Http\Controllers\Admin\Tag\ViewTagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', [ViewDashboardController::class, 'index'])->name('dashboard');

    // Category
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [ViewCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ViewCategoryController::class, 'create'])->name('create');
        Route::get('/{category}/edit', [ViewCategoryController::class, 'edit'])->name('edit');
    });

    // Tag
    Route::prefix('tag')->name('tag.')->group(function () {
        Route::get('/', [ViewTagController::class, 'index'])->name('index');
        Route::get('/create', [ViewTagController::class, 'create'])->name('create');
        Route::get('/{tag}/edit', [ViewTagController::class, 'edit'])->name('edit');
    });

    // Article
    Route::prefix('article')->name('article.')->group(function () {
        Route::get('/', [ViewArticleController::class, 'index'])->name('index');
        Route::get('/create', [ViewArticleController::class, 'create'])->name('create');
        Route::get('/{article}/edit', [ViewArticleController::class, 'edit'])->name('edit');
    });
});
