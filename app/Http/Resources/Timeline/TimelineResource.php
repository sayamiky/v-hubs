<?php

namespace App\Http\Resources\Timeline;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineResource extends JsonResource
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
            'description' => $this->description,
            'visibility' => $this->visibility ,
            'media' => TimelineMediaResource::collection($this->whenLoaded('media')),
            'created_at' => $this->created_at,
        ];
    }
}
