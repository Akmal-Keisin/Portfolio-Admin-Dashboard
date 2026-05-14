<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->sentence(),
            'thumbnail' => null,
            'live_url' => $this->faker->url(),
            'repo_url' => $this->faker->url(),
            'status' => $this->faker->randomElement(['ongoing', 'completed']),
            'featured' => $this->faker->boolean(20),
        ];
    }
}
