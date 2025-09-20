<?php

namespace App\Dtos\Story;

use App\Models\Story;
use Illuminate\Support\Carbon;

class StoryResponseDto
{
    public string $userId;
    public string $content;
    public string $createdAt;
    public bool $isExpired;

    public function __construct(Story $story)
    {
        $this->userId    = $story->user_id;
        $this->content   = $story->content;
        $this->isExpired = Carbon::now()->greaterThan($story->created_at->addDay());
    }
}
