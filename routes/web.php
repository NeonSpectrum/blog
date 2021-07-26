<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/{all}', [ViewController::class, 'index'])->where('all', '.*');
