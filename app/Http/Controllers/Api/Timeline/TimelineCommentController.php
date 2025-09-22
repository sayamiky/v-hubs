<?php

namespace App\Http\Controllers\Api\Timeline;

use App\Models\TimelineComment;
use App\Http\Requests\Timeline\StoreTimelineCommentRequest;
use App\Http\Requests\Timeline\UpdateTimelineCommentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Timeline\TimelineCommentResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TimelineCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelineCommentRequest $request)
    {
        $comment = TimelineComment::create(array_merge($request->validated(), [
            'user_id' => auth()->user()->id
        ]));

        return (new TimelineCommentResource($comment->loadMissing('user')))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimelineComment $comment)
    {
        return (new TimelineCommentResource($comment->loadMissing('user')))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimelineCommentRequest $request, TimelineComment $comment)
    {
        return (new TimelineCommentResource(tap($comment)->update($request->validated())))->additional(
            ['status' => true]
        )->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimelineComment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }

    public function commentByPost(Request $request, $post)
    {
        $comments = QueryBuilder::for(TimelineComment::where('timeline_post_id', $post))
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
            ])
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return TimelineCommentResource::collection($comments)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }
}
