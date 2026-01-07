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
        return [
            'id' => $this->id,

            'title' => $this->title,
            'body' => $this->body,

            'category' => new CategoryResource($this->whenLoaded('category')),
            'author_profile' => new ProfileResource($this->whenLoaded('authorProfile')),

            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
