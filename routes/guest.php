<?php

use App\Http\Controllers\Website\AppointmentReservationController;
use App\Http\Controllers\Website\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('website.coming-soon');
});
Route::get('/home', [HomePageController::class, '__invoke'])->name('website.home');
Route::get('/reservaciones', [AppointmentReservationController::class, '__invoke'])->name('website.reservation');

require __DIR__ . '/auth.php';
