<?php

namespace App\Dtos\Auth;

class RegisterDto
{
    public function __construct(
        // public string $role, 
        public string $name,
        public string $birthdate,
        public string $phone,
        public string $email,
        public string $gender,
        public string $password,
        public ?string $referral_id = null // hanya untuk penjual baru
    ) {}
}
