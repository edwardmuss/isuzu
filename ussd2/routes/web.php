<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;
use App\Http\Controllers\MenuOptionController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('menu_options', MenuOptionController::class);
Route::post('/menuoptions/reorder', [MenuOptionController::class, 'reorder'])->name('menuoptions.reorder');
Route::get('/menuoptions/{id}/edit', [MenuOptionController::class, 'edit2'])->name('menuoptions.edit');
Route::get('/test', [UssdController::class, 'test']);
