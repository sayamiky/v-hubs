<?php

namespace App\Http\Controllers\Api\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\Group\GroupResource;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class GroupController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = QueryBuilder::for(Group::with('owner')->where('privacy', 'public'))
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return GroupResource::collection($groups)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $group = Group::create(array_merge($request->validated(), [
            'owner_id' => Auth::user()->id,
            'cover_image' => $this->upload($request->file('cover_image'), 'group') ?? null,
        ]));

        return (new GroupResource($group->loadMissing('owner')))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return (new GroupResource($group->loadMissing('owner')))->additional([
            'message' => 'success',
            'status' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload($request->file('cover_image'), 'group');
        }
        return (new GroupResource(tap($group)->update($data)))->additional(
            ['status' => true]
        )->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json([
            'message' => 'success',
            'status' => true
        ]);
    }

    public function myGroup(Request $request)
    {
        $user = Auth::user()->id;
        $groups = QueryBuilder::for(Group::with('owner')->where('owner_id', $user)->orWhereHas('member', function ($query) use ($user) {
            $query->where('user_id', $user);
        }))
            ->allowedSorts('id')
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $request->perPage
            )->withQueryString();

        return GroupResource::collection($groups)->additional([
            'message' => 'success',
            'status' => true
        ]);
    }
}
