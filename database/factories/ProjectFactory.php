<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => $title,

            'slug' => Str::slug($title),

            'short_description' => fake()->sentence(),

            'description' => fake()->paragraphs(3, true),

            'image' => null,

            'github_url' => null,

            'live_url' => null,

            'featured' => fake()->boolean(30),

            'status' => fake()->randomElement([
                'draft',
                'published',
            ]),

            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
