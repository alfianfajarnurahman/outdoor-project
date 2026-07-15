<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BranchController;

Route::middleware('throttle:api')->group(function () {
    Route::get('/health', function () {
        return response()->json(['status' => 'ok']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::post('/forgot-password', [PasswordResetController::class, 'forgot']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::apiResource('branches', BranchController::class);

Route::get('/current-branch', function () {
    return response()->json(app('current_branch'));
});

// Test subdomain
Route::get('/test-subdomain', function () {
    $branch = request()->attributes->get('branch');
    return response()->json([
        'host' => request()->getHost(),
        'subdomain' => explode('.', request()->getHost())[0],
        'branch' => $branch,
    ]);
});