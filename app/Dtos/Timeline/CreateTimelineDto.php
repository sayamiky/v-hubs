<?php

namespace App\Dtos\Timeline;

class CreateTimelineDto
{
    public function __construct(
        public string $userId,
        public string $content
    ) {}
}
