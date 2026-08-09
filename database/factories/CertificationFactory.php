<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CertificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->catchPhrase(),
            'issuer' => fake()->company(),
            'credential_id' => strtoupper(fake()->bothify('CERT-####-????')),
            'issue_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'expiration_date' => null,
            'credential_url' => null,
            'description' => fake()->sentence(),
        ];
    }
}
