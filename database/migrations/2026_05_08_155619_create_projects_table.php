<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->index();
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->string('excerpt', 255)->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('live_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing')->index();
            $table->boolean('featured')->default(false)->index();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
