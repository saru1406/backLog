<?php

use App\Http\Controllers\API\ChildTaskApiController;
use App\Http\Controllers\API\ProjectApiController;
use App\Http\Controllers\API\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/projects/{project}/tasks', [TaskApiController::class, 'fetchTasks']);
    Route::get('/projects/{project}/tasks-board', [TaskApiController::class, 'fetchTasksByBoard']);
    Route::get('/projects/{project}/child-tasks', [ChildTaskApiController::class, 'fetchChildTasks']);
    Route::get('/projects/{project}/gant', [TaskApiController::class, 'fetchGant']);
    Route::get('/projects/{project}/new-tasks', [ProjectApiController::class, 'newTasks']);
    Route::patch('/projects/{project}/tasks/{tasks}/update', [TaskApiController::class,'updateTaskStatus']);
    Route::patch('/projects/{project}/child-tasks/{childTasks}/update', [ChildTaskApiController::class,'updateChildTaskStatus']);
});
