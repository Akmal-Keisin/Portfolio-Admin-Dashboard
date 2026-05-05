<?php

use App\Http\Controllers\Admin\Article\DeleteArticleController;
use App\Http\Controllers\Admin\Article\StoreArticleController;
use App\Http\Controllers\Admin\Article\UpdateArticleController;
use App\Http\Controllers\Admin\Article\ViewArticleController;
use App\Http\Controllers\Admin\Category\DeleteCategoryController;
use App\Http\Controllers\Admin\Category\StoreCategoryController;
use App\Http\Controllers\Admin\Category\UpdateCategoryController;
use App\Http\Controllers\Admin\Category\ViewCategoryController;
use App\Http\Controllers\Admin\Dashboard\ViewDashboardController;
use App\Http\Controllers\Admin\Tag\DeleteTagController;
use App\Http\Controllers\Admin\Tag\StoreTagController;
use App\Http\Controllers\Admin\Tag\UpdateTagController;
use App\Http\Controllers\Admin\Tag\ViewTagController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', [ViewDashboardController::class, 'index'])->name('dashboard');

    // Category
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [ViewCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ViewCategoryController::class, 'create'])->name('create');
        Route::post('/', StoreCategoryController::class)->name('store');
        Route::get('/{category}/edit', [ViewCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', UpdateCategoryController::class)->name('update');
        Route::delete('/{category}', DeleteCategoryController::class)->name('destroy');
    });

    // Tag
    Route::prefix('tag')->name('tag.')->group(function () {
        Route::get('/', [ViewTagController::class, 'index'])->name('index');
        Route::get('/create', [ViewTagController::class, 'create'])->name('create');
        Route::post('/', StoreTagController::class)->name('store');
        Route::get('/{tag}/edit', [ViewTagController::class, 'edit'])->name('edit');
        Route::put('/{tag}', UpdateTagController::class)->name('update');
        Route::delete('/{tag}', DeleteTagController::class)->name('destroy');
    });

    // Article
    Route::prefix('article')->name('article.')->group(function () {
        Route::get('/', [ViewArticleController::class, 'index'])->name('index');
        Route::post('/', StoreArticleController::class)->name('store');
        Route::get('/create', [ViewArticleController::class, 'create'])->name('create');
        Route::get('/{article}/edit', [ViewArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}', UpdateArticleController::class)->name('update');
        Route::delete('/{article}', DeleteArticleController::class)->name('destroy');
    });
});
