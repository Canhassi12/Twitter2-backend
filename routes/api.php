<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function() {
    Route::post('/register', [UserController::class, 'store'])->name('user.store');
    Route::middleware('auth:sanctum')->delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:sanctum')->post('follow/{id}', [FollowerController::class, 'followUser'])->name('follow.user');
Route::middleware('auth:sanctum')->get('/user/{id}/followers', [FollowerController::class, 'showFollowers'])->name('follow.show');

Route::middleware('auth:sanctum')->apiResource('post', PostController::class);
Route::middleware('auth:sanctum')->post('post/{id}/like', [PostController::class, 'likePost'])->name('post.like');
Route::middleware('auth:sanctum')->apiResource('comment', CommentController::class);





     