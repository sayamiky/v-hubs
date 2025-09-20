<?php

namespace App\Http\Resources\Timeline;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'media_path' => $this->media_path ? asset('storage/'.$this->media_path) : null,
                'media_type' => $this->media_type,
            ];
    }
}
