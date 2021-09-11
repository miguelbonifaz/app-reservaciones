<?php

use App\Http\Controllers\Website\AppointmentReservationController;
use App\Http\Controllers\Website\ContactPageController;
use App\Http\Controllers\Website\EvaluationPageController;
use App\Http\Controllers\Website\HomePageController;
use App\Http\Controllers\Website\TherapyPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('website.coming-soon');
});
Route::get('/home', [HomePageController::class, '__invoke'])->name('website.home');
Route::get('/contacto', [ContactPageController::class, '__invoke'])->name('website.contact');
Route::get('/terapias', [TherapyPageController::class, '__invoke'])->name('website.therapy');
Route::get('/evaluaciones', [EvaluationPageController::class, '__invoke'])->name('website.evaluation');
Route::get('/reservaciones', [AppointmentReservationController::class, '__invoke'])->name('website.reservation');

Route::get('/terminos-y-condiciones', [AppointmentReservationController::class, '__invoke'])->name('website.terms-and-conditions');

require __DIR__ . '/auth.php';
