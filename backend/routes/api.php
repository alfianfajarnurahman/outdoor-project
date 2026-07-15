<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

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


    //user CRUD
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);


    //setting CRUD
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'store']);
    Route::get('/settings/{setting}', [SettingController::class, 'show']);
    Route::put('/settings/{setting}', [SettingController::class, 'update']);
    Route::delete('/settings/{setting}', [SettingController::class, 'destroy']);
    Route::get('/settings/key/{key}', [SettingController::class, 'getByKey']);
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