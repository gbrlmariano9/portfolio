<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();

            $table->string('image', 500)->nullable();

            $table->string('github_url', 500)->nullable();
            $table->string('live_url', 500)->nullable();

            $table->boolean('featured')->default(false);

            $table->enum('status', [
                'draft',
                'published',
                'archived'
            ])->default('draft');

            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->softDeletes();

            $table->index('status');
            $table->index('featured');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
