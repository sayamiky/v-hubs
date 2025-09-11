<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'  => $this->uuid,
            'name'  => $this->name,
            'birthdate' => $this->birthdate,
            'phone' => $this->phone,
            'email' => $this->email,
            'role'  => $this->role,
            'referral_id' => $this->referral_id,
            'token' => $this->token,
        ];
    }
}
