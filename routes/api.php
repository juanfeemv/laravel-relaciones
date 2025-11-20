<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('user',UsuarioController::class);
Route::apiResource('profile',ProfileController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('post',PostController::class);
Route::apiResource('tag',TagController::class);


