<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdController;

Route::match(['get', 'post'], '/ads', [AdController::class, 'index']);
Route::match(['get', 'post'], '/ads/show/{id}', [AdController::class, 'show']);
Route::match(['get', 'post'], '/ads/create', [AdController::class, 'store']);
