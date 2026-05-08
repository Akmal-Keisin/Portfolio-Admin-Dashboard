<?php

namespace Database\Seeders;

use App\Models\TechStack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechStackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stacks = [
            ['name' => 'Laravel', 'description' => 'PHP Web Framework'],
            ['name' => 'Vue.js', 'description' => 'Progressive JavaScript Framework'],
            ['name' => 'Tailwind CSS', 'description' => 'Utility-first CSS Framework'],
            ['name' => 'PostgreSQL', 'description' => 'Open Source Relational Database'],
            ['name' => 'Docker', 'description' => 'Containerization Platform'],
            ['name' => 'Redis', 'description' => 'In-memory Data Structure Store'],
            ['name' => 'TypeScript', 'description' => 'Typed superset of JavaScript'],
            ['name' => 'Inertia.js', 'description' => 'The Modern Monolith'],
        ];

        foreach ($stacks as $stack) {
            TechStack::create([
                'name' => $stack['name'],
                'slug' => Str::slug($stack['name']),
                'description' => $stack['description'],
                'project_count' => 0,
            ]);
        }
    }
}
