<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to(
        route('login')
    );
});


require __DIR__ . '/auth.php';
