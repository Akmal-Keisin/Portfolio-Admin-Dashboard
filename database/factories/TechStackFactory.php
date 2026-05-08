<?php

namespace Database\Factories;

use App\Models\TechStack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TechStack>
 */
class TechStackFactory extends Factory
{
    protected $model = TechStack::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'project_count' => 0,
        ];
    }
}
