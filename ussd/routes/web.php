<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/', 'HomeController@index');
$router->get('/test', 'HomeController@test');

$router->post('/', 'PortalController@sendQuotePdf');

Route::options('/{any:.*}', function () {
    return response(['status' => 'success']);
});
