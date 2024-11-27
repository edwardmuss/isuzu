<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MenuOptionController;
use App\Http\Controllers\VehicleSeriesModelsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UssdUserController;
use App\Http\Controllers\VehicleSaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\TestDrivesController;
use App\Http\Controllers\BrochureController;
use App\Http\Controllers\LocateDealerController;
use App\Http\Controllers\TechnicalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PsvAwardsController;
use App\Http\Controllers\OffersController;

Route::resource('menu_options', MenuOptionController::class);
Route::post('/menuoptions/reorder', [MenuOptionController::class, 'reorder'])->name('menuoptions.reorder');
Route::get('/menuoptions/{id}/edit', [MenuOptionController::class, 'edit2'])->name('menuoptions.edit');
Route::get('/test', [UssdController::class, 'test']);

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
