<?php

namespace App\Http\Controllers;

use App\Dtos\Timeline\CreateTimelineDTO;
use App\Services\TimelineService;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function store(Request $request, TimelineService $service)
    {
        $dto = new CreateTimelineDTO(
            userId: $request->user()->id,
            content: $request->input('content')
        );

        $timelineResponse = $service->create($dto);

        return response()->json($timelineResponse);
    }
}
