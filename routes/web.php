<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return view('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/projects', [ProjectController::class, 'index'])->middleware(['auth'])->name('projects');
Route::get('/projects/create', [ProjectController::class, 'create'])->middleware(['auth'])->name('projects.create');
Route::post('/projects/create', [ProjectController::class, 'store'])->middleware(['auth'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->middleware(['auth'])->name('projects.show');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->middleware(['auth'])->name('projects.edit');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->middleware(['auth'])->name('projects.update');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->middleware(['auth'])->name('projects.destroy');

Route::get('/tasks/create', [TaskController::class, 'showCreateForm'])->middleware('auth', 'verified')->name('tasks.create.form');
Route::post('/tasks', [TaskController::class, 'create'])->middleware('auth', 'verified')->name('tasks.create');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->middleware('auth', 'verified')->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->middleware('auth', 'verified')->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware('auth', 'verified')->name('tasks.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
