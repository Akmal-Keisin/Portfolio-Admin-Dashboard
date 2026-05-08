<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'author' => $this->whenLoaded('author', fn () => $this->author->name),
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'tags' => $this->whenLoaded('tags'),
            'createdAt' => $this->created_at ? $this->created_at->format('l, F j, Y') : '-',
            'updatedAt' => $this->updated_at ? $this->updated_at->format('l, F j, Y') : '-',
        ];
    }
}
