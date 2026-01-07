<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // aquí el resto del API protegida
        Route::apiResource('user', UsuarioController::class);
        Route::apiResource('profile', ProfileController::class);
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('post', PostController::class);
        Route::apiResource('tag', TagController::class);
    });
});