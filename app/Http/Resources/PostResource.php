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
            'slug' => $this->slug,
            'title' => $this->title,
            'summary' => $this->summary,
            'user' => UserResource::make($this->whenLoaded('user')),
            'likes' => LikeResource::collection($this->likes),
            'status' => $this->when($request->user()->isAdmin(), $this->status),
            'other_field' => $this->when($request->user()->isAdmin(), fn() => rand(1, 10)),
            'created_at' => $this->whenHas('created_at'),
            'deleted_at' => $this->whenNotNull($this->deleted_at),
            'likes_count' => $this->whenCounted('likes'),
        ];
    }
}
