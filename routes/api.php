<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/authors/{user:slug}/posts', [UserController::class, 'postsByAuthor']);
Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'register');
    Route::post('/login', 'login');


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', 'logout');
        Route::get('/user', 'getUser');
    });
});


Route::get('/categories/{category:slug}/posts', [CategoryController::class, 'postsByCategory']);
Route::apiResource('categories', CategoryController::class)->only('index');
Route::apiResource('categories', CategoryController::class)->except('index')->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');


Route::get('/posts/{post:slug}/comments', [CommentController::class,'getCommentsByPost']);
Route::apiResource('comments', CommentController::class)->middleware('auth:sanctum');

