<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\PartsController;
use App\Http\Controllers\Dashboard\OffersController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\BrochureController;
use App\Http\Controllers\Dashboard\UssdUserController;
use App\Http\Controllers\Dashboard\PsvAwardsController;
use App\Http\Controllers\Dashboard\TechnicalController;
use App\Http\Controllers\Dashboard\TestDrivesController;
use App\Http\Controllers\Dashboard\VehicleSaleController;
use App\Http\Controllers\Dashboard\LocateDealerController;
use App\Http\Controllers\Dashboard\VehicleSeriesModelsController;

/*Auth::routes();*/

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/**
 * guarded routes
 */
Route::group(['middleware' => ['auth']], function () {

    // Home route
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Resource routes
    Route::resource('/ussd-users', UssdUserController::class);
    Route::resource('/vehicle-sales', VehicleSaleController::class);
    Route::resource('/service', ServiceController::class);
    Route::resource('/parts', PartsController::class);
    Route::resource('/test-drives', TestDrivesController::class);
    Route::resource('/brochure', BrochureController::class);
    Route::resource('/locate-dealer', LocateDealerController::class);
    Route::resource('/technical-assistance', TechnicalController::class);
    Route::resource('/contact-request', ContactController::class);
    Route::resource('/psv-awards', PsvAwardsController::class);
    Route::resource('/offers', OffersController::class);

    // Update routes
    Route::get('/service-update', [ServiceController::class, 'change'])->name('service_update');
    Route::get('/parts-update', [PartsController::class, 'change'])->name('parts_update');
    Route::get('/tech-update', [TechnicalController::class, 'change'])->name('tech_update');
    Route::get('/offers-update', [OffersController::class, 'change'])->name('offers_update');
    Route::get('/vehicle-update', [VehicleSaleController::class, 'change'])->name('vehicle_update');

    // Counts routes
    Route::get('index/counts', [HomeController::class, 'allcounts']);
    Route::get('index/cabs', [HomeController::class, 'pickups']);
    Route::get('index/cabs-yearly', [HomeController::class, 'pickupYearly']);
    Route::get('index/vehicle-yearly', [HomeController::class, 'vehicleSales']);

    Route::resource('vehicle-series', VehicleSeriesModelsController::class);
    Route::post('vehicle-series/upload', [VehicleSeriesModelsController::class, 'upload'])->name('vehicle-series.upload');
});
