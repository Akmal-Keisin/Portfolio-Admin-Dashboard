<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'isRead' => $this->is_read,
            'isImportant' => $this->is_important,
            'createdAt' => $this->created_at ? $this->created_at->format('l, F j, Y') : '-',
            'updatedAt' => $this->updated_at ? $this->updated_at->format('l, F j, Y') : '-',
            'diffForHumans' => $this->created_at ? $this->created_at->diffForHumans() : '-',
        ];
    }
}
