<?php

namespace App\Dtos\Timeline;

use App\Models\Timeline;

class TimelineResponseDto
{
    public string $id;
    public string $title;
    public string $description;
    public string $visibility;
    public array $media;
    public string $createdAt;

    public function __construct(Timeline $timeline)
    {
        $this->id = $timeline->id;
        $this->title = $timeline->title;
        $this->description = $timeline->description;
        $this->visibility = $timeline->visibility;

        // ambil media kalau ada
        $this->media = $timeline->media->map(fn($m) => [
            'id' => $m->id,
            'media_path' => $m->media_path,
            'media_type' => $m->media_type,
        ])->toArray();

        $this->createdAt = $timeline->created_at;
    }

    /**
     * Untuk collection (misalnya index/listing)
     */
    public static function collection($timelines): array
    {
        return $timelines->map(fn($timeline) => new self($timeline))->toArray();
    }
}
