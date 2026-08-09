<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        $technologies = [
            'PHP',
            'Laravel',
            'Vue.js',
            'React',
            'Inertia.js',
            'Tailwind CSS',
            'Bootstrap',
            'JavaScript',
            'TypeScript',
            'MySQL',
            'MariaDB',
            'Microsoft SQL Server',
            'Python',
            'FastAPI',
            'REST API',
            'Git',
            'GitHub',
            'Power BI',
        ];

        foreach ($technologies as $technology) {
            Technology::updateOrCreate(
                ['slug' => Str::slug($technology)],
                [
                    'name' => $technology,
                    'icon' => null,
                ]
            );
        }
    }
}
