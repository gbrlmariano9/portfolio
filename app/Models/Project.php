<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'image',
        'github_url',
        'live_url',
        'featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(ProjectImage::class)
            ->orderBy('sort_order');
    }

    public function technologies()
    {
        return $this->belongsToMany(
            Technology::class,
            'project_technologies'
        );
    }
}
