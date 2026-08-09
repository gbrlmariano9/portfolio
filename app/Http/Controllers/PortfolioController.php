<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::query()
            ->where('status', 'published')
            ->where('featured', true)
            ->with([
                'images' => function ($query) {
                    $query->orderByDesc('is_primary')
                        ->orderBy('sort_order');
                },
                'technologies',
            ])
            ->orderBy('sort_order')
            ->latest()
            ->get();

        $projects = Project::query()
            ->where('status', 'published')
            ->with([
                'images' => function ($query) {
                    $query->orderByDesc('is_primary')
                        ->orderBy('sort_order');
                },
                'technologies',
            ])
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return Inertia::render('Portfolio/Index', [
            'featuredProjects' => $featuredProjects,
            'projects' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        abort_unless($project->status === 'published', 404);

        $project->load([
            'images',
            'technologies',
        ]);

        return Inertia::render('Portfolio/Project', [
            'project' => $project,
            'backUrl' => route('portfolio'),
        ]);
    }


}
