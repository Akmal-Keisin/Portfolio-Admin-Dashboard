<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get IDs from related models
        $categoryIds = Category::pluck('id');
        $tagIds = Tag::pluck('id');
        $authorIds = Admin::pluck('id');

        // 2. Ensure at least one admin exists
        if ($authorIds->isEmpty()) {
            $admin = Admin::create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
            ]);
            $authorIds->push($admin->id);
        }

        // 3. Create 20 articles
        Article::factory(20)
            ->make()
            ->each(function ($article) use ($authorIds, $categoryIds, $tagIds) {
                // Assign a random author and category
                $article->author_id = $authorIds->random();
                $article->category_id = $categoryIds->random();
                $article->save();

                // Attach a random number of tags (1 to 3)
                $article->tags()->attach(
                    $tagIds->random(rand(1, 3))
                );
            });
    }
}
