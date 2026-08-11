<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CommentController;

Route::get('/test', function () {
  return response()->json([
    'message' => 'API fonctionne'
  ]);
});

// Auth (public)
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });

  Route::apiResource('projects', ProjectController::class);

  Route::apiResource('projects.tasks', TaskController::class);

  Route::apiResource('tasks.comments', CommentController::class);

  Route::apiResource('comments', CommentController::class)->only([
    'show',
    'update',
    'destroy',
  ]);
});
