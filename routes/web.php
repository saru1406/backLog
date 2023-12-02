<?php

use App\Http\Controllers\ChildTaskController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);

    Route::resource('projects.tasks', TaskController::class);
    Route::post('projects/{project}/tasks/{task}/create-branch-gpt', [TaskController::class, 'storeBranchGpt'])->name('projects.tasks.create-branch-gpt');
    Route::resource('projects.tasks.child-tasks', ChildTaskController::class);
    Route::post('projects/{project}/tasks/{task}/child-tasks/store-gpt', [ChildTaskController::class, 'storeChildTaskGpt'])->name('projects.tasks.child-tasks.store-gpt');

    Route::get('/projects/{project}/board', [ProjectController::class, 'board'])->name('projects.board');
    Route::get('/projects/{project}/gant', [ProjectController::class, 'gant'])->name('projects.gant');

    Route::post('/projects/{project}/user', [ProjectController::class, 'storeProjectUser'])->name('projects.user');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
