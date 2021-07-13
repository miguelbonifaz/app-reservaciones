<?php

use App\Http\Controllers\Website\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, '__invoke'])->name('home');


require __DIR__ . '/auth.php';
