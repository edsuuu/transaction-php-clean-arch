<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', static function (Request $request) {
        return $request->user();
    });

    Route::post('/transfer', [TransferController::class, 'store']);
    Route::post('/deposit', [DepositController::class, 'store']);
    Route::get('/balance', [AccountController::class, 'balance']);
    Route::get('/history', [AccountController::class, 'history']);
});
