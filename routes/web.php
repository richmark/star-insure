<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store']);
Route::post('/todos/bulk-delete', [TodoController::class, 'destroy']);
Route::post('/todos/bulk-update', [TodoController::class, 'update']);
