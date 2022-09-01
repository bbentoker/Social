<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{ProfileController,PostController};

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('index');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        // return Inertia::render('Dashboard');
        return redirect()->route('home');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::get('/home',function(){
        return Inertia::render('Home');
    })->name('home');
    
    Route::get('/profile',[ProfileController::class,'index']);
    Route::resource('profiles',ProfileController::class);

    Route::post('/profiles/{profile}/follow',[ProfileController::class,'follow'])->name('profiles.follow');
    Route::post('/profiles/{profile}/unfollow',[ProfileController::class,'unfollow'])->name('profiles.unfollow');
    
    Route::resource('posts',PostController::class);
});

require __DIR__.'/auth.php';


