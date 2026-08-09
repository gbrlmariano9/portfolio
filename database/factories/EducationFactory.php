<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'institution' => fake()->company(),
            'degree' => fake()->randomElement([
                'Bachelor of Science',
                'Bachelor of Information Technology',
                'Bachelor of Computer Science',
            ]),
            'field_of_study' => fake()->randomElement([
                'Information Technology',
                'Computer Science',
                'Information Systems',
            ]),
            'start_date' => fake()->dateTimeBetween('-10 years', '-5 years'),
            'end_date' => fake()->dateTimeBetween('-5 years', '-1 year'),
            'description' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
