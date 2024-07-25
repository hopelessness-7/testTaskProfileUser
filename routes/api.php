<?php

use App\Http\Controllers\API\v1\Auth\LoginController;
use App\Http\Controllers\API\v1\Auth\RegisterController;
use App\Http\Controllers\API\v1\ConfirmationController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/register', [RegisterController::class, '__invoke']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('/user', 'profile');
            Route::get('/users/show/{id}', 'show');
            Route::patch('/users/update/{id}', 'update');
        });

        Route::post('/confirmation/send', [ConfirmationController::class, 'send']);
        Route::post('/confirmation/check', [ConfirmationController::class, 'check']);
    });
});

Route::fallback(function(){
    return response()->json([
        'errors' => [
            "error" => [
                'code' => '404',
                'message' => 'Not found route api'
            ],
        ]
    ], 404);
});
