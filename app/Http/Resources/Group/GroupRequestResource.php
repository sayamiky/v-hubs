<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'group_name' => $this->group->name,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'status' => $this->status,
            'requested_at' => $this->created_at,
        ];
    }
}
