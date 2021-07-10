<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('website.home');
});


require __DIR__ . '/auth.php';
