<?php

namespace App\Dtos\Auth;

use App\Models\User;

class AuthResponseDto
{
    public string $uuid;
    public string $name;
    public string $birthdate;
    public string $phone;
    public string $email;
    public ?string $role;
    public string $gender;
    public ?string $referral_id;
    public ?string $token;

    public function __construct(User $user, ?string $token = null)
    {
        $this->uuid  = $user->uuid;
        $this->name  = $user->name;
        $this->birthdate = $user->birthdate;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->gender = $user->gender;
        $this->role  = $user->role;
        $this->referral_id = $user->referral_id;
        $this->token = $token;
    }
}
