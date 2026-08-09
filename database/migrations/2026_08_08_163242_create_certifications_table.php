<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('issuer');

            $table->string('credential_id')->nullable();

            $table->date('issue_date')->nullable();
            $table->date('expiration_date')->nullable();

            $table->string('credential_url', 500)->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index('issue_date');
            $table->index('expiration_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
