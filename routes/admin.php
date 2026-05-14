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
use App\Http\Controllers\Admin\TechStack\DeleteTechStackController;
use App\Http\Controllers\Admin\TechStack\StoreTechStackController;
use App\Http\Controllers\Admin\TechStack\UpdateTechStackController;
use App\Http\Controllers\Admin\TechStack\ViewTechStackController;
use App\Http\Controllers\Admin\Project\DeleteProjectController;
use App\Http\Controllers\Admin\Project\StoreProjectController;
use App\Http\Controllers\Admin\Project\UpdateProjectController;
use App\Http\Controllers\Admin\Project\ViewProjectController;
use App\Http\Controllers\Admin\Message\DeleteMessageController;
use App\Http\Controllers\Admin\Message\UpdateMessageStatusController;
use App\Http\Controllers\Admin\Message\ViewMessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', [ViewDashboardController::class, 'index'])->name('dashboard');

    // Message
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [ViewMessageController::class, 'index'])->name('index');
        Route::get('/{message}', [ViewMessageController::class, 'show'])->name('show');
        Route::patch('/{message}/toggle-read', [UpdateMessageStatusController::class, 'toggleRead'])->name('toggle-read');
        Route::patch('/{message}/toggle-important', [UpdateMessageStatusController::class, 'toggleImportant'])->name('toggle-important');
        Route::patch('/{message}/toggle-archive', [UpdateMessageStatusController::class, 'toggleArchive'])->name('toggle-archive');
        Route::delete('/{message}', DeleteMessageController::class)->name('destroy');
    });

    // Project
    Route::prefix('project')->name('project.')->group(function () {
        Route::get('/', [ViewProjectController::class, 'index'])->name('index');
        Route::get('/create', [ViewProjectController::class, 'create'])->name('create');
        Route::post('/', StoreProjectController::class)->name('store');
        Route::get('/{project}/edit', [ViewProjectController::class, 'edit'])->name('edit');
        Route::post('/{project}', UpdateProjectController::class)->name('update');
        Route::delete('/{project}', DeleteProjectController::class)->name('destroy');
    });

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

    // Tech Stack
    Route::prefix('tech-stack')->name('tech-stack.')->group(function () {
        Route::get('/', [ViewTechStackController::class, 'index'])->name('index');
        Route::get('/create', [ViewTechStackController::class, 'create'])->name('create');
        Route::post('/', StoreTechStackController::class)->name('store');
        Route::get('/{tech_stack}/edit', [ViewTechStackController::class, 'edit'])->name('edit');
        Route::put('/{tech_stack}', UpdateTechStackController::class)->name('update');
        Route::delete('/{tech_stack}', DeleteTechStackController::class)->name('destroy');
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
