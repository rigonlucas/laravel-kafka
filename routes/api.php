<?php

Route::post('auth/login', \App\Http\Controllers\Auth\LoginController::class)
    ->name('auth.login');
