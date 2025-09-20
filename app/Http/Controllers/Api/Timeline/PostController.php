<?php
namespace App\Http\Controllers\Api\Timeline;

use App\Dtos\Timeline\CreateTimelineDto;
use App\Http\Controllers\Controller;
use App\Models\Timeline;
use App\Http\Requests\Timeline\StoreTimelineRequest;
use App\Http\Requests\Timeline\UpdateTimelineRequest;
use App\Http\Resources\Timeline\TimelineResource;
use App\Services\TimelineService;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    protected TimelineService $timelineService;

    public function __construct(TimelineService $timelineService)
    {
        $this->timelineService = $timelineService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = QueryBuilder::for($this->timelineService->getAll())
            ->allowedFilters([
                AllowedFilter::exact('title'),
            ])
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->get();

        return TimelineResource::collection($posts)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelineRequest $request): JsonResponse
    {
        $dto = CreateTimelineDto::fromRequest($request);
        $timeline = $this->timelineService->create($dto);

        return response()->json([
            'data' => new TimelineResource($timeline->loadMissing('media')),
            'message' => 'Timeline created successfully',
            'status' => true
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timeline $timeline)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimelineRequest $request, Timeline $timeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timeline $timeline)
    {
        //
    }
}
