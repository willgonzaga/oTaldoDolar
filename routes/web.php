<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;

Route::get('/', [ExchangeRateController::class, 'index']);
