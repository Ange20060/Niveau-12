<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CommentController;

Route::apiResource('projects', ProjectController::class);

Route::apiResource('projects.tasks', TaskController::class)
    ->shallow();

Route::apiResource('tasks.comments', CommentController::class)
    ->shallow();
