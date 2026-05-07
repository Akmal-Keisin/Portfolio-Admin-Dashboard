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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->index()->constrained('admins');
            $table->foreignId('category_id')->index()->constrained('categories');
            $table->string('title', 255)->index();
            $table->string('slug', 255)->unique();
            $table->string('excerpt', 255);
            $table->jsonb('content');
            $table->enum('status', ['draft', 'published', 'archived'])->index()->default('draft');
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropIndex(['author_id']);
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['status']);
        });
        Schema::dropIfExists('articles');
    }
};
