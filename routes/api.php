<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
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

Route::get('/user', [AuthController::class, 'user']);
Route::get('/blogs/all', [BlogController::class, 'all']);
Route::post('/blogs/{id}/comment', [BlogController::class, 'comment']);

Route::apiResource('users', UserController::class)->middleware('role:admin');
Route::apiResource('blogs', BlogController::class);
Route::apiResource('categories', CategoryController::class)->only('index');
Route::apiResource('comments', CommentController::class)->only('destroy');
