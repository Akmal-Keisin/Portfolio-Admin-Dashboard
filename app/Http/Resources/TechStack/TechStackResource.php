<?php

namespace App\Http\Resources\TechStack;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechStackResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'projectCount' => $this->project_count,
            'createdAt' => $this->created_at ? $this->created_at->format('l, F j, Y') : '-',
            'updatedAt' => $this->updated_at ? $this->updated_at->format('l, F j, Y') : '-',
        ];
    }
}
