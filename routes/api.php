<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

    Route::post('signin', [AdminController::class, 'loginAdmin']);

    Route::middleware(['auth:sanctum', 'ability:superAdmin'])->group(function () {
        Route::post('create', [AdminController::class, 'createAdmin']);
    });

    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'createUser']);
    });
});

Route::prefix('user')->group(function () {
    Route::post('signin', [UserController::class, 'loginUser']);
});
