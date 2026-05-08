<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\TechStack\TechStackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
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
            'description' => $this->description,
            'excerpt' => $this->excerpt,
            'thumbnail' => $this->thumbnail ? Storage::url($this->thumbnail) : null,
            'live_url' => $this->live_url,
            'repo_url' => $this->repo_url,
            'status' => $this->status,
            'featured' => $this->featured,
            'tech_stacks' => TechStackResource::collection($this->whenLoaded('techStacks')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
