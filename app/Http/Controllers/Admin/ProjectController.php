<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\ProjectImage;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index(): Response
    {
        $projects = Project::query()
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Projects/Create');
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:projects,slug',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'github_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'live_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'featured' => [
                'boolean',
            ],

            'status' => [
                'required',
                'in:draft,published,archived',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate slug automatically
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug'] ?? null;

        if (empty($slug)) {
            $slug = Str::slug($validated['title']);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure slug is unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        /*
        |--------------------------------------------------------------------------
        | Featured checkbox
        |--------------------------------------------------------------------------
        */

        $validated['featured'] = $request->boolean('featured');

        /*
        |--------------------------------------------------------------------------
        | Create project
        |--------------------------------------------------------------------------
        */

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {


        return Inertia::render('Admin/Projects/Show', [
            'project' => $project->load([
                'images',
                'technologies',
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project->load([
                'images',
                'technologies',
            ]),

            'technologies' => \App\Models\Technology::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:projects,slug,' . $project->id,
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'github_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'live_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'featured' => [
                'boolean',
            ],

            'status' => [
                'required',
                'in:draft,published,archived',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            // Technologies
            'technologies' => [
                'nullable',
                'array',
            ],

            'technologies.*' => [
                'integer',
                'exists:technologies,id',
            ],

            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'image_alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate slug if empty
        |--------------------------------------------------------------------------
        */

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure slug is unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $validated['slug'];
        $counter = 1;

        while (
            Project::where('slug', $validated['slug'])
            ->where('id', '!=', $project->id)
            ->exists()
        ) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
        |--------------------------------------------------------------------------
        | Featured checkbox
        |--------------------------------------------------------------------------
        */

        $validated['featured'] = $request->boolean('featured');

        /*
        |--------------------------------------------------------------------------
        | Update project
        |--------------------------------------------------------------------------
        */

        $project->update($validated);

        $project->technologies()->sync($request->input('technologies', []));

        /*
        |--------------------------------------------------------------------------
        | Upload project images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store(
                    'projects/' . $project->id,
                    'public'
                );

                $project->images()->create([
                    'image_path' => $path,
                    'alt_text' => $request->input('image_alt_text'),
                    'is_primary' => $project->images()->count() === 0,
                    'sort_order' => $project->images()->count(),
                ]);
            }
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Set a project image as the primary image.
     */
    public function setPrimaryImage(Project $project, ProjectImage $image)
    {
        // Make sure the image actually belongs to this project
        abort_unless($image->project_id === $project->id, 404);

        // Remove primary status from all other images
        $project->images()->update([
            'is_primary' => false,
        ]);

        // Set selected image as primary
        $image->update([
            'is_primary' => true,
        ]);

        return back()->with(
            'success',
            'Primary image updated successfully.'
        );
    }

    /**
     * Delete a project image.
     */
    public function deleteImage(Project $project, ProjectImage $image)
    {
        // Make sure the image actually belongs to this project
        abort_unless($image->project_id === $project->id, 404);

        // Delete physical file from storage
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete database record
        $image->delete();

        return back()->with(
            'success',
            'Project image deleted successfully.'
        );
    }

    /**
     * Update a project image.
     */
    public function updateImage(
        Request $request,
        Project $project,
        ProjectImage $image
    ) {
        // Make sure the image belongs to this project
        abort_unless($image->project_id === $project->id, 404);

        $validated = $request->validate([
            'alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $image->update($validated);

        return back()->with(
            'success',
            'Project image updated successfully.'
        );
    }


    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
