<?php

namespace App\Http\Controllers\Api\Timeline;

use App\Models\TimelineLike;
use App\Http\Requests\Timeline\StoreTimelineLikeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TimelineLikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelineLikeRequest $request)
    {
        $request->validated();

        return response()->json([
            'data' => TimelineLike::create([
                'timeline_post_id' => $request->timeline_post_id,
                'user_id' => auth()->user()->id
            ]),
            'message' => 'success',
            'status' => true
        ])->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimelineLike $like)
    {
        $like->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }

    public function likeByPost(Request $request, $post)
    {
        $likes = QueryBuilder::for(TimelineLike::where('timeline_post_id', $post))
            ->allowedFilters([
                AllowedFilter::exact('member_id'),
            ])
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return response()->json([
            'data' => $likes,
            'message' => 'success',
            'status' => true
        ]);
    }
}
