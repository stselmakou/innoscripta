<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Feed\FeedController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('feed', [FeedController::class, 'get'])->name('feed');
        Route::post('feed', [FeedController::class, 'save'])->name('feed.preference');

    });
    Route::any('login', [LoginController::class, 'index'])->name('login');
    Route::post('register', [RegisterController::class, 'index'])->name('register');
