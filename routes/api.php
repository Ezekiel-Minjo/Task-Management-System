<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// Optional: Keep this route if you still want to check authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User management routes (NO auth middleware)
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Task management routes (NO auth middleware)
Route::post('/tasks/assign', [TaskController::class, 'assign']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

Route::get('/notifications/{userId}', [NotificationController::class, 'index']);
