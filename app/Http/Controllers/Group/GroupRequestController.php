<?php

namespace App\Http\Controllers\Group;

use App\Events\Group\UpdatedRequestGroup;
use App\Http\Controllers\Controller;
use App\Models\GroupRequest;
use App\Http\Requests\Group\StoreGroupRequestRequest;
use App\Http\Requests\Group\UpdateGroupRequestRequest;
use App\Http\Resources\Group\GroupRequestResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class GroupRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function requestByGroup(Request $request, $group)
    {
        $reqs = QueryBuilder::for(GroupRequest::where('group_id', $group))
            ->allowedFilters('status')
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return GroupRequestResource::collection($reqs)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequestRequest $request)
    {
        $comment = GroupRequest::create(array_merge($request->validated(), [
            'user_id' => auth()->user()->id,
            'status' => 'pending'
        ]));

        return (new GroupRequestResource($comment))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupRequest $request)
    {
        return (new GroupRequestResource($request))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequestRequest $requests, GroupRequest $request)
    {
        $data = tap($request)->update($requests->validated());
        event(new UpdatedRequestGroup($data));
        return (new GroupRequestResource($data))->additional(
            ['status' => true]
        )->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupRequest $request)
    {
        $request->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }
}
