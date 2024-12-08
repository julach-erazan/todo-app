<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user/register', [UserController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);
Route::post('add/tasks', [TaskController::class, 'store']);