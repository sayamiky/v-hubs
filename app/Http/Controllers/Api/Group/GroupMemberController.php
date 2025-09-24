<?php

namespace App\Http\Controllers\Api\Group;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use App\Http\Requests\Group\StoreGroupMemberRequest;
use App\Http\Requests\Group\UpdateGroupMemberRequest;
use App\Http\Resources\Group\GroupMemberResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function memberByGroup(Request $request, $group)
    {
        $groups = QueryBuilder::for(GroupMember::where('group_id', $group))
            ->allowedFilters('role')
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return GroupMemberResource::collection($groups)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupMemberRequest $request)
    {
        $member = GroupMember::create(array_merge($request->validated(), [
            'user_id' => auth()->user()->id
        ]));

        return (new GroupMemberResource($member))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupMember $member)
    {
        return (new GroupMemberResource($member))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupMember $member)
    {
        $member->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }


}
