<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{PassportAuthController,UserController,ProfileController,PostController,HomeController};

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    
    Route::get('/home',[HomeController::class,'home']);
    
    Route::apiResource('users',UserController::class);
    
    Route::apiResource('profiles',ProfileController::class);    
    Route::post('/follow/{profile}',[ProfileController::class,'follow']);
    Route::post('/unfollow/{profile}',[ProfileController::class,'unfollow']);

    Route::apiResource('posts',PostController::class);    
    Route::post('/posts/{post}/comment',[PostController::class,'comment']);
    
});