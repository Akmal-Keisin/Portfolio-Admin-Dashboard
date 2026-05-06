<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Articles related to web development, frameworks, and best practices.',
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Articles about mobile app development for iOS and Android.',
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Design principles, user experience, and interface design articles.',
            ],
            [
                'name' => 'DevOps',
                'description' => 'DevOps practices, CI/CD pipelines, and infrastructure management.',
            ],
            [
                'name' => 'Database',
                'description' => 'Database design, optimization, and management articles.',
            ],
            [
                'name' => 'Cloud Computing',
                'description' => 'Cloud services, deployment, and cloud architecture articles.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'article_count' => 0,
            ]);
        }
    }
}
