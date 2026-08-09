<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company' => fake()->company(),
            'position' => fake()->jobTitle(),
            'location' => 'Philippines',
            'employment_type' => fake()->randomElement([
                'Full-time',
                'Part-time',
                'Contract',
            ]),
            'start_date' => fake()->dateTimeBetween('-8 years', '-2 years'),
            'end_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_current' => false,
            'description' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
