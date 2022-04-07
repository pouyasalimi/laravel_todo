<?php

use Illuminate\Support\Facades\Route;
use Psli\Todo\Http\Controllers\LabelApiController;
use Psli\Todo\Http\Controllers\UserTaskApiController;

Route::prefix('api/todo')
    ->name('api.todos.labels.')
    ->middleware(['auth.todo'])
    ->group(function () {
        Route::get('/labels', [LabelApiController::class, 'index'])->name('index');
        Route::post('/labels', [LabelApiController::class, 'store'])->name('store');
    });

Route::prefix('api/todo')
    ->name('api.todos.tasks.')
    ->middleware(['auth.todo'])
    ->group(function () {
        Route::get('/tasks', [UserTaskApiController::class, 'index'])->name('index');
        Route::post('/tasks', [UserTaskApiController::class, 'store'])->name('store');
        Route::post('/tasks/labels/', [UserTaskApiController::class, 'attachLabelToTask'])
            ->name('attach.label.to.task');
        Route::get('/tasks/{id}', [UserTaskApiController::class, 'show'])->name('show');
        Route::put('/tasks/{id}', [UserTaskApiController::class, 'update'])->name('update');
        Route::put('/tasks/{id}/status', [UserTaskApiController::class, 'status'])->name('status');
    });
