<?php

namespace App\Services;

use App\Dtos\Timeline\CreateTimelineDTO;
use App\Dtos\Timeline\TimelineResponseDTO;
use App\Models\Timeline;

class TimelineService
{
    public function create(CreateTimelineDTO $dto): TimelineResponseDTO
    {
        $timeline = Timeline::create([
            'user_id' => $dto->userId,
            'content' => $dto->content,
        ]);

        return new TimelineResponseDTO($timeline);
    }
}
