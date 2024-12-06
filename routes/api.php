<?php
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\TaskController;
    use App\Http\Controllers\AuthController;

    Route::post('/login', [AuthController::class, 'login']);
    
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::put('/tasks/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    });
?>