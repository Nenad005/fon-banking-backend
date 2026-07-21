<?php

use App\Http\Controllers\ActivationCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivationCodeController::class, 'index']);
