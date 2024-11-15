<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

#Usuários
Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::delete('/{id}/delete', [UserController::class, 'delete']);
});