<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TechStack;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $techStacks = TechStack::all();

        if ($techStacks->isEmpty()) {
            $this->call(TechStackSeeder::class);
            $techStacks = TechStack::all();
        }

        Project::factory()
            ->count(10)
            ->create()
            ->each(function (Project $project) use ($techStacks) {
                $project->techStacks()->attach(
                    $techStacks->random(rand(2, 4))->pluck('id')->toArray()
                );
            });
    }
}
