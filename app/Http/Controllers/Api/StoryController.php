<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Http\Requests\Story\StoreStoryRequest;
use App\Http\Resources\StoryResource;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StoryController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stories = QueryBuilder::for(Story::active()->where('user_id', auth()->user()->id))
            ->allowedFilters([
                AllowedFilter::exact('title'),
            ])
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->get();

        return StoryResource::collection($stories)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoryRequest $request)
    {
        $story = Story::create(array_merge($request->validated(), [
            'user_id' => auth()->user()->id,
            'media_path' => $this->upload($request->file('media_path'), 'story'),
            'expires_at' => now()->addHours(24)
        ]));

        return (new StoryResource($story))->additional([
            'message' => 'success',
            'status' => true
        ])->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        return (new StoryResource($story))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        $story->update([
            'deleted_by' => auth()->user()->id
        ]);
        $story->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }
}
