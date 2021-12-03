<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [ApiTokenController::class, 'register']);
Route::post('/login', [ApiTokenController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [ApiTokenController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/tasks/{id}', [TaskController::class, 'delete']);
Route::middleware('auth:sanctum')->put('/tasks/{id}', [TaskController::class, 'delete']);

// Route::middleware()->apiResource()