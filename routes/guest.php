<?php

use App\Http\Controllers\Website\AppointmentReservationController;
use App\Http\Controllers\Website\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppointmentReservationController::class, '__invoke'])->name('website.reservation');

require __DIR__ . '/auth.php';
