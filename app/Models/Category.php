<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'article_count'];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'article_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
