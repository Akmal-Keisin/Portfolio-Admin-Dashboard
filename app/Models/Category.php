<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'article_count'];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'article_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the articles for the category.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
