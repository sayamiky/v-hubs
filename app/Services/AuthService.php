<?php

namespace App\Services;

use App\Dtos\Auth\AuthResponseDTO;
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
    public function register(RegisterDto $dto): AuthResponseDTO
    {
        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $dto->name,
            'birthdate' => $dto->birthdate,
            'phone' => $dto->phone,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'referral_id' => $dto->referral_id,
        ]);


        $user->assignRole($dto->role); // ✅ assign role (wajib role sudah ada di tabel roles)

        $token = $user->createToken('auth_token')->accessToken;

        return new AuthResponseDTO($user, $token);
    }

    public function login(LoginDto $dto): AuthResponseDTO
    {
        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user  = Auth::user();
        $token = $user->createToken('auth_token')->accessToken;

        return new AuthResponseDTO($user, $token);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
