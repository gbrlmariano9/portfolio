<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->jobTitle(),
            'category' => fake()->randomElement([
                'Backend',
                'Frontend',
                'Database',
                'DevOps',
                'Data',
            ]),
            'proficiency' => fake()->randomElement([
                'intermediate',
                'advanced',
                'expert',
            ]),
            'years_experience' => fake()->randomFloat(1, 1, 8),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
