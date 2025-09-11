<?php

namespace App\Dtos\Timeline;

use App\Models\Timeline;

class TimelineResponseDto
{
    public string $id;
    public string $userId;
    public string $content;

    public function __construct(Timeline $timeline)
    {
        $this->id = $timeline->id;
        $this->userId = $timeline->user_id;
        $this->content = $timeline->content;
    }
}
