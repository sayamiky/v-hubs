<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\Timeline\PostController;
use App\Http\Controllers\Api\Timeline\TimelineCommentController;
use App\Http\Controllers\Api\Timeline\TimelineLikeController;
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
            Route::get('/posts-profile', [PostController::class, 'timelineProfile']);
            Route::apiResource('/comments', TimelineCommentController::class);
            Route::get('/posts/{post}/comment', [TimelineCommentController::class, 'commentByPost']);
            Route::apiResource('/likes', TimelineLikeController::class)->only(['store', 'destroy']);
            Route::get('/posts/{post}/like', [TimelineLikeController::class, 'likeByPost']);
        });

        Route::apiResource('stories', StoryController::class);
    });
});
