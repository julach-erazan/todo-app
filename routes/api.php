<?php
    use Illuminate\Http\Request;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\TaskController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\Controller;

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\PostController;

    Route::post('/login', [AuthController::class, 'login']);
    
    Route::post('/reg', [Controller::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::put('/tasks/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    });
?>
