<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-sentry', function () {
    throw new Exception('Test error untuk Sentry!');
});

Route::get('/password/reset/{token}', function ($token) {
    return response()->json(['token' => $token]);
})->name('password.reset');