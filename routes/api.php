<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function (): void {
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::get('/accounts/{accountId}/cards', [CardController::class, 'index']);
    Route::post('/transactions/transfer', [TransactionController::class, 'store']);
    Route::get('/accounts/{accountId}/transactions', [TransactionController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('api')->prefix('v1')->group(function(): void {
    Route::post('/activate', [AuthController::class, 'activate']);
    Route::post('/set_pin', [AuthController::class, 'setupPin']);
    Route::post('/login', [AuthController::class, 'login']);
});