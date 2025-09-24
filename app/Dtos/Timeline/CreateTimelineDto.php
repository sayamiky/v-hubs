<?php

namespace App\Dtos\Timeline;

class CreateTimelineDto
{
    public function __construct(
        public string $user_id,
        public ?string $group_id,
        public string $title,
        public ?string $description,
        public string $visibility,
        public array $media = []
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            user_id: auth()->user()->id,
            group_id: $request->group_id,
            title: $request->title,
            description: $request->description,
            visibility: $request->visibility,
            media: $request->media ?? []
        );
    }
}
