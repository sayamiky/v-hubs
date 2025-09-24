<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $service)
    {
        $response = $service->register($request->toDto());
        return (new AuthResource($response))->additional([
            'message' => "register success!",
            'status' => true,
        ]);
    }

    public function login(LoginRequest $request, AuthService $service)
    {
        $response = $service->login($request->toDto());
        return (new AuthResource($response))->additional([
            'message' => "login success!",
            'status' => true,
        ]);
    }

    public function logout(Request $request, AuthService $service)
    {
        $service->logout($request->user());
        return response()->json([
            'message' => "logout success!",
            'status' => true,
        ]);
    }
}
