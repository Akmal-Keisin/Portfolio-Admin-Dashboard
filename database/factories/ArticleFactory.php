<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        $paragraph = fake()->paragraph(3);

        return [
            'title' => $title,
            'excerpt' => substr($paragraph, 0, 160),
            'content' => [
                'type' => 'doc',
                'content' => [
                    [
                        'type' => 'paragraph',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $paragraph,
                            ],
                        ],
                    ],
                ],
            ],
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
