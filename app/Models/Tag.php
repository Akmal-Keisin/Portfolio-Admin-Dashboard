<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
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
     * The articles that belong to the tag.
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
