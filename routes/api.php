<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;

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
    Route::get('/{id}/show', [TagController::class, 'show']);
    Route::post('/store', [TagController::class, 'store']);
    Route::put('/{id}/update', [TagController::class, 'update']);
    Route::delete('/{id}/delete', [TagController::class, 'delete']);
});