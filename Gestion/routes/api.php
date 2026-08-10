<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CommentController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
  return response()->json([
    'message' => 'API fonctionne'
  ]);
});

Route::apiResource('projects', ProjectController::class);

Route::apiResource('projects.tasks', TaskController::class)
  ->only([
    'index',
    'store',
  ]);

Route::apiResource('tasks.comments', CommentController::class)
  ->only([
    'index',
    'store',
  ]);
Route::apiResource('comments', CommentController::class)
  ->only([
    'show',
    'update',
    'destroy',
  ]);

Route::middleware('auth:sanctum')->group(function () {

  Route::apiResource('projects', ProjectController::class);

  Route::apiResource('tasks', TaskController::class);

  Route::apiResource('comments', CommentController::class);
});
