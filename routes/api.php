<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::post('auth/register', [ApiTokenController::class, 'register']);
Route::post('auth/login', [ApiTokenController::class, 'login']);
Route::middleware('auth:sanctum')->post('auth/me', [ApiTokenController::class, 'me']);
Route::middleware('auth:sanctum')->post('auth/logout', [ApiTokenController::class, 'logout']);

Route::middleware('auth:sanctum')->get('auth/tasks', [PostController::class, 'index']);
Route::middleware('auth:sanctum')->get('auth/tasks/{id}', [PostController::class, 'show']);
Route::middleware('auth:sanctum')->post('auth/tasks', [PostController::class, 'create']);
Route::middleware('auth:sanctum')->delete('auth/tasks/{id}', [PostController::class, 'delete']);
Route::middleware('auth:sanctum')->put('auth/tasks/{id}', [PostController::class, 'delete']);

// Route::middleware()->apiResource()