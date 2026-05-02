<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'articleCount' => $this->article_count,
            'createdAt' => $this->created_at ? $this->created_at->format(("l, F j, Y")) : '-',
            'updatedAt' => $this->updated_at ? $this->updated_at->format(("l, F j, Y")) : '-'
        ];
    }
}
