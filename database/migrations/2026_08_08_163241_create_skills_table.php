<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            $table->string('category', 100)->nullable();

            $table->enum('proficiency', [
                'beginner',
                'intermediate',
                'advanced',
                'expert'
            ])->default('intermediate');

            $table->decimal('years_experience', 4, 1)->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->index('category');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
