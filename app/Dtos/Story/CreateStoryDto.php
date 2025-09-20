<?php

namespace App\Dtos\Story;

class CreateStoryDto
{
    public function __construct(
        public string $userId,
        public string $content
    ) {}
}
