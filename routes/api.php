<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ussd', [UssdController::class, 'index']);
// Route::post('/ussd', [UssdController::class, 'handleUssdRequest']);
