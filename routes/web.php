<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);
Route::get('tasks/view', [TaskController::class, 'view']);
Route::post('tasks/add', [TaskController::class, 'add']);