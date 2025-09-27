<?php

namespace App\Services;

use App\Dtos\Auth\AuthResponseDto;
use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(RegisterDto $dto): AuthResponseDto
    {
        $user = User::create([
            'name' => $dto->name,
            'birthdate' => $dto->birthdate,
            'phone' => $dto->phone,
            'email' => $dto->email,
            'gender' => $dto->gender,
            'password' => Hash::make($dto->password),
            'referral_id' => $dto->referral_id,
        ]);

        $role = $dto->referral_id ? 'seller' : 'user';
        $user->assignRole($role); // ✅ assign role 

        $token = $user->createToken('auth_token')->accessToken;

        return new AuthResponseDto($user, $token);
    }

    public function login(LoginDto $dto): AuthResponseDto
    {
        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user  = Auth::user();
        $token = $user->createToken('auth_token')->accessToken;

        return new AuthResponseDto($user, $token);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
