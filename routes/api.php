<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'register');
    Route::post('/login', 'login');


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', 'logout');
        Route::get('/user', 'getUser');
    });
});
