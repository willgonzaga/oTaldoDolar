<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;

Route::get('/', [ExchangeRateController::class, 'index']);

Route::get('/favicon/favicon.ico', fn () => response()->file(public_path('favicon/favicon.ico')));
Route::get('/favicon/favicon-16x16.png', fn () => response()->file(public_path('favicon/favicon-16x16.png')));
Route::get('/favicon/favicon-32x32.png', fn () => response()->file(public_path('favicon/favicon-32x32.png')));
Route::get('/favicon/apple-touch-icon.png', fn () => response()->file(public_path('favicon/apple-touch-icon.png')));
