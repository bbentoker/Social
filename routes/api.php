<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PassportAuthController,UserController,ProfileController,PostController,HomeController};

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    
    Route::get('/home',[HomeController::class,'home']);
    
    Route::apiResource('users',UserController::class);
    
    Route::apiResource('profiles',ProfileController::class);    

    Route::apiResource('posts',PostController::class);    
    
});
