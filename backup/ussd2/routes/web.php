<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;
use App\Http\Controllers\MenuOptionController;
use App\Http\Controllers\VehicleSeriesModelsController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('menu_options', MenuOptionController::class);
Route::post('/menuoptions/reorder', [MenuOptionController::class, 'reorder'])->name('menuoptions.reorder');
Route::get('/menuoptions/{id}/edit', [MenuOptionController::class, 'edit2'])->name('menuoptions.edit');
Route::get('/test', [UssdController::class, 'test']);

/*Auth::routes();*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/**
 * guarded routes
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/ussd-users', 'UssdUserController');
    Route::resource('/vehicle-sales', 'VehicleSaleController');
    Route::resource('/service', 'ServiceController');
    Route::get('/service-update', 'ServiceController@change')->name('service_update');
    Route::get('/parts-update', 'PartsController@change')->name('parts_update');
    Route::get('/tech-update', 'TechnicalController@change')->name('tech_update');
    Route::get('/offers-update', 'OffersController@change')->name('offers_update');
    Route::get('/vehicle-update', 'VehicleSaleController@change')->name('vehicle_update');
    Route::resource('/parts', 'PartsController');
    Route::resource('/test-drives', 'TestDrivesController');
    Route::resource('/brochure', 'BrochureController');
    Route::resource('/locate-dealer', 'LocateDealerController');
    Route::resource('/technical-assistance', 'TechnicalController');
    Route::resource('/contact-request', 'ContactController');
    Route::resource('/psv-awards', 'PsvAwardsController');
    Route::resource('/offers', 'OffersController');

    Route::get('index/counts', 'HomeController@allcounts');
    Route::get('index/cabs', 'HomeController@pickups');
    Route::get('index/cabs-yearly', 'HomeController@pickupYearly');
    Route::get('index/vehicle-yearly', 'HomeController@vehicleSales');

    Route::resource('vehicle-series', VehicleSeriesModelsController::class);
    Route::post('vehicle-series/upload', [VehicleSeriesModelsController::class, 'upload'])->name('vehicle-series.upload');
});
