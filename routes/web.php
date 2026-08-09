<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\ProjectController;


Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])->name('portfolio.projects.show');





Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('projects', ProjectController::class);

        Route::delete(
            'projects/{project}/images/{image}',
            [ProjectController::class, 'deleteImage']
        )->name('projects.images.delete');

        Route::post(
            'projects/{project}/images/{image}/primary',
            [ProjectController::class, 'setPrimaryImage']
        )->name('projects.images.primary');

        Route::put(
            'projects/{project}/images/{image}',
            [ProjectController::class, 'updateImage']
        )->name('projects.images.update');


    });



require __DIR__ . '/auth.php';
