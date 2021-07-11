<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
});








Route::prefix('/employees')->group(function () {
    Route::get('/', [EmployeesController::class, 'index'])->name('employees.index');
});