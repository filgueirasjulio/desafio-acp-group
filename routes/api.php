<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

#Usuários
Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::delete('/{id}/delete', [UserController::class, 'delete']);
});

#tags
Route::group(['prefix' => 'tag', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [TagController::class, 'index']);
    Route::get('/{id}/show', [TagController::class, 'show']);
    Route::post('/store', [TagController::class, 'store']);
    Route::put('/{id}/update', [TagController::class, 'update']);
    Route::delete('/{id}/delete', [TagController::class, 'delete']);
});

#posts
Route::group(['prefix' => 'post', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}/show', [PostController::class, 'show']);
    Route::post('/store', [PostController::class, 'store']);
    Route::put('/{id}/update', [PostController::class, 'update']);
    Route::delete('/{id}/delete', [PostController::class, 'delete']);
});