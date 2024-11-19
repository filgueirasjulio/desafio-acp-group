<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load(['user', 'tags']);

        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => new UserResource($this->user),
            'tags' => TagResource::collection($this->tags),
            'created_at' => $this->created_at
        ];
    }
}
