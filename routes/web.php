<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');;
});

Route::get('/api/token', function (Request $request) {
    return $request->user()->createToken('web')->plainTextToken;
});