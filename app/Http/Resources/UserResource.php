<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'posts' => $this->whenLoaded('posts'),
            $this->mergeWhen($request->user()->isAdmin(), [
                'secret-value' => 123,
                'other-secret-value' => 46,
            ]),
            $this->mergeUnless($request->user()->isAdmin(), [
                'secret-value' => null,
                'other-secret-value' => 789,
            ]),
            'latest_post_created_at' => $this->whenAggregated('posts', 'created_at', 'max')

        ];
    }
}
