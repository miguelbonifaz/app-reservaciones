<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');       
    Route::get('/{user}/avatar', [UserPhotoController::class, '__invoke'])->name('users.remove');
});

Route::prefix('/employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
});
