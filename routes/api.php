<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\Timeline\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'timeline'], function () {
            Route::apiResource('/posts', PostController::class);
            Route::apiResource('/comments', PostController::class);
            Route::apiResource('/likes', PostController::class);

        });
        
        Route::apiResource('stories', StoryController::class);
    });
});
