<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DeleteBreakTimeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/email', function () {
    $appointment = \App\Models\Appointment::first();

    $appointment->customer->notify(new \App\Notifications\AppointmentConfirmedNotification($appointment));
});

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
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/{employee}/breakTime/{restSchedule}', [DeleteBreakTimeController::class, '__invoke'])->name('employess.break-time.destroy');
});

Route::prefix('/services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::post('/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

Route::prefix('/customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});

Route::prefix('/locations')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('locations.index');
});

Route::prefix('/profile')->group(function () {
    Route::get('/{user}/edit', [MyProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/{user}/', [MyProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('/appointments')->group(function () {
    Route::get('/create', [AppointmentController::class, 'create'])->name('appointments.create');
});
