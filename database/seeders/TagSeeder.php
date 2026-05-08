<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'description' => 'Articles about Laravel PHP framework.',
            ],
            [
                'name' => 'Vue.js',
                'description' => 'Articles about Vue.js JavaScript framework.',
            ],
            [
                'name' => 'React',
                'description' => 'Articles about React JavaScript library.',
            ],
            [
                'name' => 'TypeScript',
                'description' => 'Articles about TypeScript programming language.',
            ],
            [
                'name' => 'Docker',
                'description' => 'Articles about Docker containerization.',
            ],
            [
                'name' => 'AWS',
                'description' => 'Articles about Amazon Web Services.',
            ],
            [
                'name' => 'API',
                'description' => 'Articles about API design and development.',
            ],
            [
                'name' => 'Performance',
                'description' => 'Articles about performance optimization.',
            ],
            [
                'name' => 'Security',
                'description' => 'Articles about security best practices.',
            ],
            [
                'name' => 'Testing',
                'description' => 'Articles about software testing.',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'description' => $tag['description'],
                'article_count' => 0,
            ]);
        }
    }
}
