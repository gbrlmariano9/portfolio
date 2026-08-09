<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'NPI-DAS Inventory Management System',
                'slug' => 'npi-das-inventory-management-system',
                'short_description' => 'Inventory management and encoding system for business operations.',
                'description' => 'A Laravel-based inventory management system designed to streamline inventory submission, encoding, assignment, validation, and reporting workflows.',
                'github_url' => null,
                'live_url' => null,
                'featured' => true,
                'status' => 'published',
                'sort_order' => 1,
                'technologies' => [
                    'Laravel',
                    'PHP',
                    'MySQL',
                    'Bootstrap',
                    'JavaScript',
                ],
            ],

            [
                'title' => 'AI PDF Analyzer',
                'slug' => 'ai-pdf-analyzer',
                'short_description' => 'AI-assisted PDF analysis system built with Python and FastAPI.',
                'description' => 'A Python-based application that extracts information from PDF documents and processes the extracted content using AI-assisted analysis.',
                'github_url' => null,
                'live_url' => null,
                'featured' => true,
                'status' => 'published',
                'sort_order' => 2,
                'technologies' => [
                    'Python',
                    'FastAPI',
                ],
            ],

            [
                'title' => 'Face Recognition System',
                'slug' => 'face-recognition-system',
                'short_description' => 'Computer vision based face recognition application.',
                'description' => 'A Python-based face recognition system using computer vision and machine learning libraries for face detection and recognition.',
                'github_url' => null,
                'live_url' => null,
                'featured' => false,
                'status' => 'published',
                'sort_order' => 3,
                'technologies' => [
                    'Python',
                ],
            ],

            [
                'title' => 'Portfolio Management System',
                'slug' => 'portfolio-management-system',
                'short_description' => 'Full-stack developer portfolio built with Laravel, Vue, and Inertia.',
                'description' => 'A modern portfolio platform featuring public portfolio pages and an administrative dashboard for managing projects, skills, experience, education, certifications, and contact messages.',
                'github_url' => 'https://github.com/gbrlmariano9/portfolio',
                'live_url' => null,
                'featured' => true,
                'status' => 'published',
                'sort_order' => 4,
                'technologies' => [
                    'Laravel',
                    'PHP',
                    'Vue.js',
                    'Inertia.js',
                    'Tailwind CSS',
                    'MySQL',
                    'Git',
                    'GitHub',
                ],
            ],
        ];

        foreach ($projects as $projectData) {
            $technologies = $projectData['technologies'];

            unset($projectData['technologies']);

            $project = Project::updateOrCreate(
                [
                    'slug' => $projectData['slug'],
                ],
                $projectData
            );

            $technologyIds = Technology::whereIn(
                'name',
                $technologies
            )->pluck('id');

            $project->technologies()->sync($technologyIds);
        }
    }
}
